package com.dilshan.task;

import com.mashape.unirest.http.Unirest;
import com.mashape.unirest.request.HttpRequestWithBody;
import org.joda.time.DateTime;
import org.joda.time.format.DateTimeFormat;
import org.joda.time.format.DateTimeFormatter;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.util.ArrayList;
import java.util.logging.Level;
import java.util.logging.Logger;

public class DeleteElasticSearchIndex implements Runnable {

    private final Logger log = Logger.getLogger(this.getClass().getPackage().getName());

    private String username;
    private String password;
    private Connection connection;

    public DeleteElasticSearchIndex(String username, String password) {
        this.username = username;
        this.password = password;
    }

    @Override
    public void run() {
        try {
            log.info("Checking for delete task status");

            String url = "jdbc:mysql://localhost:3306/automotive-search-engine";
            String driver = "com.mysql.jdbc.Driver";
            Class.forName(driver).newInstance();
            connection = DriverManager.getConnection(url, username, password);

            String statusQuery = "SELECT delete_status FROM task_status";
            ResultSet statuses = connection.createStatement().executeQuery(statusQuery);
            if (statuses.next()) {
                int deleteStatus = statuses.getInt("delete_status");
                if (deleteStatus > 0) {
                    int expiry = 30;
                    String settingsQuery = "SELECT setting_value FROM setting WHERE setting_key = 'VehicleExpiryTime'";
                    ResultSet settings = connection.createStatement().executeQuery(settingsQuery);
                    if (settings.next()) {
                        expiry = settings.getInt("setting_value");
                    }

                    delete(expiry);
                }
            }

            connection.close();
        } catch (Exception ex) {
            log.log(Level.SEVERE, ex.getMessage(), ex);
        }
    }

    private void delete(int expiry) throws Exception {
        ArrayList<String> docs = getDocuments(expiry);
        int counter = docs.size();
        while (docs.size() > 0) {
            remove(docs);
            log.log(Level.INFO, "Removed : " + counter);
            docs = getDocuments(expiry);
            counter += docs.size();
        }
    }

    private ArrayList<String> getDocuments(int expiry) throws Exception {
        ArrayList<String> objects = new ArrayList<String>();

        DateTime now = new DateTime();
        DateTime limit = now.minusDays(expiry);
        DateTimeFormatter format = DateTimeFormat.forPattern("yyyy-MM-dd hh:mm:ss");
        String param = "'" + format.print(limit) + "'";

        String vehiclesQuery = "SELECT vin FROM vehicle WHERE deleted = 0 AND modified = 0 AND updated_at < " + param + " LIMIT 1000";
        ResultSet vehicles = connection.createStatement().executeQuery(vehiclesQuery);
        while (vehicles.next()) {
            objects.add(vehicles.getString("vin"));
        }

        return objects;
    }

    public void remove(ArrayList<String> docs) throws Exception {
        StringBuilder data = new StringBuilder();
        StringBuilder vins = new StringBuilder();

        for (String vin : docs) {
            String meta = String.format("{ \"delete\" : { \"_id\" : \"%s\" } }", vin);

            data.append(meta);
            data.append("\n");

            vins.append("'" + vin + "',");
        }

        Unirest.put("http://localhost:9200/vehicles/vehicle/_bulk")
                .header("accept", "application/json")
                .body(data.toString())
                .asJson();

        vins.deleteCharAt(vins.lastIndexOf(","));

        String query = "UPDATE vehicle SET deleted = 1 WHERE vin in (" + vins.toString() + ")";
        connection.createStatement().executeUpdate(query);
    }
}
