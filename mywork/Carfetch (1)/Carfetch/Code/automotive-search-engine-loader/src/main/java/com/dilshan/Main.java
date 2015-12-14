package com.dilshan;

import com.dilshan.task.*;

import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;
import java.util.logging.Logger;

public class Main {

    private final static Logger log = Logger.getLogger(Main.class.getPackage().getName());

    public static void main(String[] args) {
        try {
            String path = args[0];
            int minutes = Integer.parseInt(args[1]);
            String username = args[2];
            String password = "";
            if (args.length > 3) {
                password = args[3];
            }

            ScheduledExecutorService scheduledExecutorService = Executors.newScheduledThreadPool(5);

            ReadDataFile readDataFile = new ReadDataFile(path, username, password);
            RecreateElasticSearchIndex recreateElasticSearchIndex = new RecreateElasticSearchIndex(username, password);
            UpdateElasticSearchIndex updateElasticSearchIndex = new UpdateElasticSearchIndex(username, password);
            DeleteElasticSearchIndex deleteElasticSearchIndex = new DeleteElasticSearchIndex(username, password);
            FixDealerStatus fixDealerStatus = new FixDealerStatus(username, password);

            scheduledExecutorService.scheduleAtFixedRate(readDataFile, 0, minutes, TimeUnit.MINUTES);
            scheduledExecutorService.scheduleAtFixedRate(recreateElasticSearchIndex, 0, minutes, TimeUnit.MINUTES);
            scheduledExecutorService.scheduleAtFixedRate(updateElasticSearchIndex, 0, minutes, TimeUnit.MINUTES);
            scheduledExecutorService.scheduleAtFixedRate(deleteElasticSearchIndex, 0, minutes, TimeUnit.MINUTES);
            scheduledExecutorService.scheduleAtFixedRate(fixDealerStatus, 0, 1, TimeUnit.DAYS);
        } catch (Exception ex) {
            log.severe(ex.getMessage());
        }
    }
}