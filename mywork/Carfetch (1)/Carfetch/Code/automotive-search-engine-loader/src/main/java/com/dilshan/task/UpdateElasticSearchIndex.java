package com.dilshan.task;

import com.dilshan.entity.Vehicle;
import com.google.gson.Gson;
import com.google.gson.JsonObject;
import com.mashape.unirest.http.Unirest;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class UpdateElasticSearchIndex implements Runnable {

    private final Logger log = Logger.getLogger(this.getClass().getPackage().getName());

    private String username;
    private String password;
    private Connection connection;

    public UpdateElasticSearchIndex(String username, String password) {
        this.username = username;
        this.password = password;
    }

    @Override
    public void run() {
        try {
            log.info("Checking for update task status");

            String url = "jdbc:mysql://localhost:3306/automotive-search-engine";
            String driver = "com.mysql.jdbc.Driver";
            Class.forName(driver).newInstance();
            connection = DriverManager.getConnection(url, username, password);

            String statusQuery = "SELECT update_status, recreate_status FROM task_status";
            ResultSet statuses = connection.createStatement().executeQuery(statusQuery);
            if (statuses.next()) {
                int updateStatus = statuses.getInt("update_status");
                int recreateStatus = statuses.getInt("recreate_status");
                if (recreateStatus == 0 && updateStatus > 0) {
                    update();
                }
            }

            connection.close();
        } catch (Exception ex) {
            log.log(Level.SEVERE, ex.getMessage(), ex);
        }
    }

    private void update() throws Exception {
        ArrayList<JsonObject> docs = getDocuments();
        int counter = docs.size();
        while (docs.size() > 0) {
            index(docs);
            log.log(Level.INFO, "Updated : " + counter);
            docs = getDocuments();
            counter += docs.size();
        }
    }

    private ArrayList<JsonObject> getDocuments() throws Exception {
        ArrayList<JsonObject> objects = new ArrayList<JsonObject>();

        String vehiclesQuery = "SELECT * FROM vehicle WHERE modified = 1 AND deleted = 0 LIMIT 1000";
        ResultSet vehicles = connection.createStatement().executeQuery(vehiclesQuery);
        while (vehicles.next()) {
            Vehicle vehicle = new Vehicle();
            vehicle.year = vehicles.getInt("year");
            vehicle.make = vehicles.getInt("make");
            vehicle.model = vehicles.getInt("model");
            vehicle.feature = vehicles.getInt("feature");
            vehicle.status = vehicles.getInt("status");
            vehicle.body = vehicles.getInt("body");
            vehicle.fuel = vehicles.getInt("fuel");
            vehicle.drive = vehicles.getInt("drive");
            vehicle.interior = vehicles.getInt("interior");
            vehicle.exterior = vehicles.getInt("exterior");
            vehicle.miles = vehicles.getInt("miles");
            vehicle.transmission = vehicles.getInt("transmission");
            vehicle.zip = vehicles.getInt("zip");
            vehicle.doors = vehicles.getInt("doors");
            vehicle.cylinders = vehicles.getInt("cylinders");
            vehicle.dealer = vehicles.getInt("dealer");
            vehicle.price = vehicles.getDouble("price");
            vehicle.latitude = vehicles.getDouble("latitude");
            vehicle.longitude = vehicles.getDouble("longitude");
            vehicle.certified = vehicles.getInt("certified");
            vehicle.vin = vehicles.getString("vin");
            vehicle.url = vehicles.getString("url");
            vehicle.address = vehicles.getString("address");
            vehicle.city = vehicles.getString("city");
            vehicle.state = vehicles.getString("state");
            vehicle.photo = vehicles.getString("photo");
            vehicle.paid = vehicles.getInt("paid");

            objects.add(getDocument(vehicle));
        }

        return objects;
    }

    private JsonObject getDocument(Vehicle vehicle) throws Exception {
        JsonObject json = new JsonObject();

        if (vehicle.vin != null && vehicle.vin.trim().length() > 0) json.addProperty("vin", vehicle.vin);
        if (vehicle.url != null && vehicle.url.trim().length() > 0) json.addProperty("url", vehicle.url);
        if (vehicle.address != null && vehicle.address.trim().length() > 0) json.addProperty("address", vehicle.address);
        if (vehicle.city != null && vehicle.city.trim().length() > 0) json.addProperty("city", vehicle.city);
        if (vehicle.state != null && vehicle.state.trim().length() > 0) json.addProperty("state", vehicle.state);
        if (vehicle.photo != null && vehicle.photo.trim().length() > 0) json.addProperty("photo", vehicle.photo);

        if (vehicle.year > 0) json.addProperty("year", vehicle.year);
        if (vehicle.make > 0) json.addProperty("make", vehicle.make);
        if (vehicle.model > 0) json.addProperty("model", vehicle.model);
        if (vehicle.feature > 0) json.addProperty("feature", vehicle.feature);
        if (vehicle.status > 0) json.addProperty("status", vehicle.status);
        if (vehicle.body > 0) json.addProperty("body", vehicle.body);
        if (vehicle.fuel > 0) json.addProperty("fuel", vehicle.fuel);
        if (vehicle.drive > 0) json.addProperty("drive", vehicle.drive);
        if (vehicle.interior > 0) json.addProperty("interior", vehicle.interior);
        if (vehicle.exterior > 0) json.addProperty("exterior", vehicle.exterior);
        if (vehicle.miles > 0) json.addProperty("miles", vehicle.miles);
        if (vehicle.transmission > 0) json.addProperty("transmission", vehicle.transmission);
        if (vehicle.zip > 0) json.addProperty("zip", vehicle.zip);
        if (vehicle.doors > 0) json.addProperty("doors", vehicle.doors);
        if (vehicle.cylinders > 0) json.addProperty("cylinders", vehicle.cylinders);
        if (vehicle.price > 0) json.addProperty("price", vehicle.price);
        if (vehicle.dealer > 0) json.addProperty("dealer", vehicle.dealer);

        json.addProperty("certified", vehicle.certified);
        json.addProperty("paid", vehicle.paid);

        JsonObject location = new JsonObject();
        location.addProperty("lat", vehicle.latitude);
        location.addProperty("lon", vehicle.longitude);
        JsonObject pin = new JsonObject();
        pin.add("location", location);
        json.add("pin", pin);

        return json;
    }

    public void index(ArrayList<JsonObject> docs) throws Exception {
        StringBuilder data = new StringBuilder();
        Gson gson = new Gson();

        StringBuilder vins = new StringBuilder();

        for (JsonObject json : docs) {
            String id = json.get("vin").toString();
            String meta = String.format("{ \"index\" : { \"_id\" : %s } }", id);
            String payload = gson.toJson(json).replaceAll("[\r\n]+", " ");

            data.append(meta);
            data.append("\n");
            data.append(payload);
            data.append("\n");

            vins.append(id + ",");
        }

        Unirest.put("http://localhost:9200/vehicles/vehicle/_bulk")
                .header("accept", "application/json")
                .body(data.toString())
                .asJson();

        vins.deleteCharAt(vins.lastIndexOf(","));

        String query = "UPDATE vehicle SET modified = 0 WHERE vin in (" + vins.toString() + ")";
        connection.createStatement().executeUpdate(query);
    }
}
