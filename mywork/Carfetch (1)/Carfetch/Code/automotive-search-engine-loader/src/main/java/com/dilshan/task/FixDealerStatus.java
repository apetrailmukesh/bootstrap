package com.dilshan.task;

import org.joda.time.DateTime;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.util.logging.Level;
import java.util.logging.Logger;

public class FixDealerStatus implements Runnable {

    private final Logger log = Logger.getLogger(this.getClass().getPackage().getName());

    private String username;
    private String password;
    private Connection connection;

    public FixDealerStatus(String username, String password) {
        this.username = username;
        this.password = password;
    }

    @Override
    public void run() {
        try {
            log.info("Checking for fix dealer status task status");

            String url = "jdbc:mysql://localhost:3306/automotive-search-engine";
            String driver = "com.mysql.jdbc.Driver";
            Class.forName(driver).newInstance();
            connection = DriverManager.getConnection(url, username, password);

            String statusQuery = "SELECT dealer_status FROM task_status";
            ResultSet statuses = connection.createStatement().executeQuery(statusQuery);
            if (statuses.next()) {
                int dealerStatus = statuses.getInt("dealer_status");
                if (dealerStatus > 0) {
                    fix();
                }
            }

            connection.close();
        } catch (Exception ex) {
            log.log(Level.SEVERE, ex.getMessage(), ex);
        }
    }

    private void fix() throws Exception {
        DateTime dateTime = new DateTime();
        int day = dateTime.getDayOfMonth();
        if (day == 1) {
            DateTime lastMonth = dateTime.minusMonths(1);
            int year = lastMonth.getYear();
            int month = lastMonth.getMonthOfYear();

            String paidDealerQuery = "SELECT id, current_clicks, paid_clicks FROM dealer WHERE paid = 1";
            ResultSet dealers = connection.createStatement().executeQuery(paidDealerQuery);
            while (dealers.next()) {
                int id = dealers.getInt("id");
                int currentClicks = dealers.getInt("current_clicks");
                int paidClicks = dealers.getInt("paid_clicks");

                String insertHistory = String.format("INSERT INTO dealer_history(dealer, year, month, paid_clicks, total_clicks) VALUES (\"%s\", \"%s\", \"%s\", \"%s\", \"%s\")", id, year, month, paidClicks, currentClicks);
                connection.createStatement().executeUpdate(insertHistory);

                String updateDealer = String.format("UPDATE dealer SET active = 1, current_clicks = 0, paid_clicks = 0 WHERE id = %s", id);
                connection.createStatement().executeUpdate(updateDealer);

                String updateVehicles = String.format("UPDATE vehicle SET paid = 1, modified = 1 WHERE dealer = %s", id);
                connection.createStatement().executeUpdate(updateVehicles);
            }
        }
    }
}
