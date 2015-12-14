package com.dilshan.entity;

import java.sql.Connection;
import java.sql.SQLException;
import java.util.logging.Level;
import java.util.logging.Logger;

public class Vehicle {

    public int year;
    public int make;
    public int model;
    public int feature;
    public int status;
    public int body;
    public int fuel;
    public int drive;
    public int interior;
    public int exterior;
    public int miles;
    public int transmission;
    public int zip;
    public int doors;
    public int cylinders;
    public int dealer;
    public int certified;
    public double price;
    public double latitude;
    public double longitude;
    public String vin;
    public String url;
    public String address;
    public String city;
    public String state;
    public String photo;
    public int paid;

    private final Logger log = Logger.getLogger(this.getClass().getPackage().getName());

    public void save(Connection connection) {
        try {
            String vinValue = vin == null ? "" : vin;
            String urlValue = url == null ? "" : url;
            String addressValue = address == null ? "" : address;
            String cityValue = city == null ? "" : city;
            String stateValue = state == null ? "" : state;
            String photoValue = photo == null ? "" : photo;

            String query = String.format("INSERT INTO vehicle " +
                            "(vin, year, make, model, dealer, url, feature, status, body, fuel, drive, interior, exterior, miles, transmission, zip, doors, cylinders, price, latitude, longitude, certified, address, city, state, photo, paid, modified) VALUES" +
                            "(\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\",\"%s\")",
                    vinValue, year, make, model, dealer, urlValue, feature, status, body, fuel, drive, interior, exterior, miles, transmission, zip, doors, cylinders, price, latitude, longitude, certified, addressValue, cityValue, stateValue, photoValue, paid, 1);

            connection.createStatement().executeUpdate(query);
        } catch (SQLException e) {
            log.log(Level.WARNING, e.getMessage(), e);
        }
    }
}
