package com.dilshan.task;

import au.com.bytecode.opencsv.CSVReader;
import com.dilshan.entity.Vehicle;

import java.io.File;
import java.io.FileReader;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.util.HashMap;
import java.util.logging.Level;
import java.util.logging.Logger;

public class ReadDataFile implements Runnable {

    private final Logger log = Logger.getLogger(this.getClass().getPackage().getName());

    private String dataPath;
    private String username;
    private String password;
    private Connection connection;

    public ReadDataFile(String path, String username, String password) {
        this.dataPath = path + File.separator + "uploads";
        this.username = username;
        this.password = password;
    }

    @Override
    public void run() {
        try {
            log.info("Checking for read task status");

            String url = "jdbc:mysql://localhost:3306/automotive-search-engine";
            String driver = "com.mysql.jdbc.Driver";
            Class.forName(driver).newInstance();
            connection = DriverManager.getConnection(url, username, password);

            String statusQuery = "SELECT read_status, recreate_status FROM task_status";
            ResultSet statuses = connection.createStatement().executeQuery(statusQuery);
            if (statuses.next()) {
                int readStatus = statuses.getInt("read_status");
                if (readStatus > 0) {
                    read();
                }
            }

            connection.close();
        } catch (Exception ex) {
            log.log(Level.SEVERE, ex.getMessage(), ex);
        }
    }

    private void read() throws Exception {
        String dataFilesQuery = "SELECT id, name FROM data_file WHERE status = 'Pending'";
        ResultSet dataFiles = connection.createStatement().executeQuery(dataFilesQuery);

        while (dataFiles.next()) {
            int id = dataFiles.getInt("id");
            String name = dataFiles.getString("name");
            String extension = name.substring(name.lastIndexOf(".") + 1);
            String dataFile = dataPath + File.separator + id + "." + extension;

            if (extension.equalsIgnoreCase("csv")) {
                log.info("Started processing uploaded file " + name);
                CSVReader reader = new CSVReader(new FileReader(dataFile));
                process(reader);
                String updateStatusQuery = String.format("UPDATE data_file SET status = 'Done' WHERE id = %s", id);
                connection.createStatement().execute(updateStatusQuery);
                log.info("Done processing uploaded file " + name);
            }
        }
    }

    private void process(CSVReader reader) throws Exception {
        HashMap<String, Integer> columns = new HashMap<String, Integer>();
        String[] header = reader.readNext();
        for (int i = 0; i < header.length; i++) {
            String head = header[i].toLowerCase();
            columns.put(head, i);
        }

        String[] nextLine;
        int counter = 1;
        while ((nextLine = reader.readNext()) != null) {
            log.log(Level.INFO, "Processing line : " + counter);
            Vehicle vehicle = processRow(nextLine, columns);
            if (vehicle != null) {
                vehicle.save(connection);
            }

            counter++;
        }
    }

    private Vehicle processRow(String[] line, HashMap<String, Integer> columns) {
        Vehicle vehicle;

        try {
            vehicle = new Vehicle();

            if (columns.containsKey("vin")) vehicle.vin = line[columns.get("vin")];
            if (columns.containsKey("url")) vehicle.url = line[columns.get("url")];
            if (columns.containsKey("address")) vehicle.address = line[columns.get("address")];
            if (columns.containsKey("city")) vehicle.city = line[columns.get("city")];
            if (columns.containsKey("state")) vehicle.state = line[columns.get("state")];
            if (columns.containsKey("photo")) vehicle.photo = line[columns.get("photo")];

            if (columns.containsKey("certified")) vehicle.certified = getBoolean(line[columns.get("photo")]) ? 1 : 0;

            if (columns.containsKey("year")) vehicle.year = getInt(line[columns.get("year")]);
            if (columns.containsKey("miles")) vehicle.miles = getInt(line[columns.get("miles")]);
            if (columns.containsKey("zip")) vehicle.zip = getInt(line[columns.get("zip")]);
            if (columns.containsKey("doors")) vehicle.doors = getInt(line[columns.get("doors")]);
            if (columns.containsKey("cylinders")) vehicle.cylinders = getInt(line[columns.get("cylinders")]);

            if (columns.containsKey("price")) vehicle.price = getDouble(line[columns.get("price")]);
            if (columns.containsKey("latitude")) vehicle.latitude = getDouble(line[columns.get("latitude")]);
            if (columns.containsKey("longitude")) vehicle.longitude = getDouble(line[columns.get("longitude")]);

            if (columns.containsKey("make")) vehicle.make = getPropertyId("make", line[columns.get("make")]);
            if (columns.containsKey("model")) vehicle.model = getPropertyId("model", line[columns.get("model")]);
            if (columns.containsKey("feature")) vehicle.feature = getPropertyId("feature", line[columns.get("feature")]);
            if (columns.containsKey("status")) vehicle.status = getPropertyId("status", line[columns.get("status")]);
            if (columns.containsKey("body")) vehicle.body = getPropertyId("body", line[columns.get("body")]);
            if (columns.containsKey("fuel")) vehicle.fuel = getPropertyId("fuel", line[columns.get("fuel")]);
            if (columns.containsKey("drive")) vehicle.drive = getPropertyId("drive", line[columns.get("drive")]);
            if (columns.containsKey("interior")) vehicle.interior = getPropertyId("interior", line[columns.get("interior")]);
            if (columns.containsKey("exterior")) vehicle.exterior = getPropertyId("exterior", line[columns.get("exterior")]);
            if (columns.containsKey("transmission")) vehicle.transmission = getPropertyId("transmission", line[columns.get("transmission")]);

            if (columns.containsKey("dealer")) setDealerProperties(vehicle, line[columns.get("dealer")]);

            if (columns.containsKey("make") && columns.containsKey("model")) {
                setSuggestions(vehicle, line[columns.get("make")], line[columns.get("model")]);
            }
        } catch (Exception ex) {
            vehicle = null;
            log.log(Level.SEVERE, ex.getMessage(), ex);
        }

        return vehicle;
    }

    private boolean getBoolean(String value) {
        boolean response = false;
        try {
            if (value != null && value.trim().length() > 0) {
                response = Boolean.parseBoolean(value.trim());
            }
        } catch (Exception ex) {
            log.log(Level.INFO, "Invalid boolean value found");
        }

        return response;
    }

    private int getInt(String value) {
        int response = 0;
        try {
            if (value != null && value.trim().length() > 0) {
                response = Integer.parseInt(value.trim());
            }
        } catch (Exception ex) {
            log.log(Level.INFO, "Invalid integer value found");
        }

        return response;
    }

    private double getDouble(String value) {
        double response = 0;
        try {
            if (value != null && value.trim().length() > 0) {
                response = Double.parseDouble(value.trim());
            }
        } catch (Exception ex) {
            log.log(Level.INFO, "Invalid double value found");
        }

        return response;
    }

    private int getPropertyId(String property, String value) throws Exception {
        int id = 0;

        if (value != null && value.trim().length() > 0) {
            String select = String.format("SELECT id FROM " + property + " WHERE " + property + " = \"%s\"", value);
            ResultSet results = connection.createStatement().executeQuery(select);
            if (results.next()) {
                id = results.getInt("id");
            } else {
                String insert = String.format("INSERT INTO " + property + "(" + property + ") VALUES (\"%s\")", value);
                connection.createStatement().executeUpdate(insert);
                results = connection.createStatement().executeQuery(select);
                if (results.next()) {
                    id = results.getInt("id");
                }
            }
        }

        return id;
    }

    private void setDealerProperties(Vehicle vehicle, String value) throws Exception {
        if (value != null && value.trim().length() > 0) {
            String select = String.format("SELECT id, active FROM dealer WHERE dealer = \"%s\"", value);
            ResultSet results = connection.createStatement().executeQuery(select);
            if (results.next()) {
                vehicle.dealer = results.getInt("id");
                vehicle.paid = results.getInt("active");
            } else {
                String insert = String.format("INSERT INTO dealer(dealer, paid, active, monthly_clicks, current_clicks) VALUES (\"%s\", \"%s\", \"%s\", \"%s\", \"%s\")", value, 0, 0, 0, 0);
                connection.createStatement().executeUpdate(insert);
                results = connection.createStatement().executeQuery(select);
                if (results.next()) {
                    vehicle.dealer = results.getInt("id");
                    vehicle.paid = results.getInt("active");
                }
            }
        }
    }

    private void setSuggestions(Vehicle vehicle, String make, String model) throws Exception {
        if (make.trim().length() > 0 && model.trim().length() > 0) {
            String template = "INSERT INTO search_suggestion(suggestion, make, model, rank) VALUES (\"%s\", \"%s\", \"%s\", \"%s\")";

            String select = String.format("SELECT id FROM search_suggestion WHERE suggestion = \"%s\"", make);
            ResultSet results = connection.createStatement().executeQuery(select);
            if (!results.next()) {
                String insert = String.format(template, make, vehicle.make, 0, 1);
                connection.createStatement().executeUpdate(insert);
            }

            String makeModel = make + " " + model;
            select = String.format("SELECT id FROM search_suggestion WHERE suggestion = \"%s\"", makeModel);
            results = connection.createStatement().executeQuery(select);
            if (!results.next()) {
                String insert = String.format(template, makeModel, vehicle.make, vehicle.model, 2);
                connection.createStatement().executeUpdate(insert);
            }
        }
    }
}
