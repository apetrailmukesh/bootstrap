package com.dilshan.task;

import com.google.gson.Gson;
import com.google.gson.JsonObject;
import com.mashape.unirest.http.Unirest;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.util.logging.Level;
import java.util.logging.Logger;

public class RecreateElasticSearchIndex implements Runnable {

    private final Logger log = Logger.getLogger(this.getClass().getPackage().getName());

    private String username;
    private String password;
    private Connection connection;

    public RecreateElasticSearchIndex(String username, String password) {
        this.username = username;
        this.password = password;
    }

    @Override
    public void run() {
        try {
            log.info("Checking for recreate index task status");

            String url = "jdbc:mysql://localhost:3306/automotive-search-engine";
            String driver = "com.mysql.jdbc.Driver";
            Class.forName(driver).newInstance();
            connection = DriverManager.getConnection(url, username, password);

            String statusQuery = "SELECT recreate_status FROM task_status";
            ResultSet statuses = connection.createStatement().executeQuery(statusQuery);
            if (statuses.next()) {
                int recreateStatus = statuses.getInt("recreate_status");
                if (recreateStatus > 0) {
                    recreate();
                }
            }

            connection.close();
        } catch (Exception ex) {
            log.log(Level.SEVERE, ex.getMessage(), ex);
        }
    }

    private void recreate() throws Exception {
        JsonObject properties = new JsonObject();

        String[] longValues = new String[]{"year", "make", "model", "feature", "status", "body", "fuel", "drive",
                "interior", "exterior", "miles", "transmission", "zip", "doors", "cylinders", "dealer", "certified", "paid"};
        for (String key : longValues) {
            JsonObject property = new JsonObject();
            property.addProperty("type", "long");
            properties.add(key, property);
        }

        String[] doubleValues = new String[]{"price"};
        for (String key : doubleValues) {
            JsonObject property = new JsonObject();
            property.addProperty("type", "double");
            properties.add(key, property);
        }

        String[] stringValues = new String[]{"vin", "url", "address", "city", "state", "photo"};
        for (String key : stringValues) {
            JsonObject property = new JsonObject();
            property.addProperty("type", "string");
            property.addProperty("index", "not_analyzed");
            properties.add(key, property);
        }

        JsonObject location = new JsonObject();
        location.addProperty("type", "geo_point");
        JsonObject pinProperties = new JsonObject();
        pinProperties.add("location", location);
        JsonObject pin = new JsonObject();
        pin.add("properties", pinProperties);
        properties.add("pin", pin);

        JsonObject vehicle = new JsonObject();
        vehicle.add("properties", properties);

        JsonObject mapping = new JsonObject();
        mapping.add("vehicle", vehicle);

        Gson gson = new Gson();
        String payload = gson.toJson(mapping);

        Unirest.put("http://localhost:9200/vehicles/_mapping/vehicle")
                .header("accept", "application/json")
                .body(payload)
                .asJson();

        String updateStatusQuery = "UPDATE task_status SET recreate_status = 0";
        connection.createStatement().executeUpdate(updateStatusQuery);
    }
}
