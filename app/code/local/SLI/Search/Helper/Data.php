<?php
/**
 * Copyright (c) 2013 S.L.I. Systems, Inc. (www.sli-systems.com) - All Rights Reserved
 * This file is part of Learning Search Connect.
 * Learning Search Connect is distribute under license,
 * go to www.sli-systems.com/LSC for full license details.
 *
 * THIS CODE AND INFORMATION ARE PROVIDED "AS IS" WITHOUT WARRANTY OF ANY
 * KIND, EITHER EXPRESSED OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND/OR FITNESS FOR A
 * PARTICULAR PURPOSE.
 * 
 * Translation and systems configuration helper
 * 
 * @package SLI
 * @subpackage Search
 */

class SLI_Search_Helper_Data extends Mage_Core_Helper_Abstract {

    const SECTION = "sli_search/";
    const GENERAL_GROUP = "general/";
    const FEED_GROUP = "feed/";
    const FTP_GROUP = "ftp/";
    const JS_GROUP = "js/";
    const CRON_GROUP = "cron/";
    const ATTR_GROUP = "attributes/";
    const DEFAULT_ATTRS = "default_attributes/";  
    const ENABLED = 1;
    const DISABLED = 2;
    const FEEDENABLED = 3;  

    /**
     * Returns true/false on whether or not the module is enabled
     *
     * @return boolean
     */
    public function isEnabled($store_id = 0) {
        $enabled = Mage::app()->getStore($store_id)->getConfig(self::SECTION . self::GENERAL_GROUP . 'enabled');
        return (bool) ($enabled == self::ENABLED) ? 1 : 0; 
    }

    /**
     * Returns true/false on whether or not the feed is enabled
     *
     * @return boolean
     */
    public function isFeedEnabled($store_id = 0) {
        $feedEnabled = Mage::app()->getStore($store_id)->getConfig(self::SECTION . self::GENERAL_GROUP . 'enabled');
        return (bool) ($feedEnabled != self::DISABLED) ? 1 : 0; 
    }

    /**
     * Returns true/false on whether or not the price feed is enabled
     *
     * @return boolean
     */
    public function isPriceFeedEnabled($store_id = 0) {
        return (bool) Mage::app()->getStore($store_id)->getConfig(self::SECTION . self::GENERAL_GROUP . 'price_feed');
    }    
    
    /**
     * Returns an integer which is the log level
     *
     * @return int
     */
    public function getLogLevel($store_id = 0) {
        return (int) Mage::app()->getStore($store_id)->getConfig(self::SECTION . self::GENERAL_GROUP . 'log_level');
    }    
    
    /**
     * Returns true/false on whether or not we should backup feeds
     *
     * @return boolean
     */
    public function isBackupFeed() {
        return (bool) Mage::getStoreConfig(self::SECTION . self::FEED_GROUP . "backup");
    }

    /**
     * Returns true/false on whether or not we should drop tables
     *
     * @return boolean
     */
    public function isDataPersistent() {
        return (bool) Mage::getStoreConfig(self::SECTION . self::FEED_GROUP . "persistent_data");
    }

    /**
     * Returns true/false on whether or not to include out of stock items in feed
     *
     * @return boolean
     */
    public function isIncludeOutOfStockItems($store_id = 0) {
        return (bool) Mage::app()->getStore($store_id)->getConfig(self::SECTION . self::FEED_GROUP . "stockstatus");
    }    
    
    /**
     * Returns true/false on whether or not to include disabled categories in feed
     *
     * @return boolean
     */
    public function isIncludeDisabledCategories($store_id = 0) {
        return (bool) Mage::app()->getStore($store_id)->getConfig(self::SECTION . self::FEED_GROUP . "categorystatus");
    }   
    
    /**
     * Returns true/false on whether or not we should drop tables;
     *
     * @return int
     */
    public function getWriteBatch() {
        return (int) Mage::getStoreConfig(self::SECTION . self::FEED_GROUP . "write_batch");
    }

    /**
     * Returns true/false on whether or not we should use ftp on feed generation
     *
     * @return boolean
     */
    public function isUseFtp() {
        return (bool) Mage::getStoreConfig(self::SECTION . self::FTP_GROUP . "enabled");
    }

    /**
     * Returns the user by which to log into the ftp server
     *
     * @return string
     */
    public function getFtpUser() {
        return Mage::getStoreConfig(self::SECTION . self::FTP_GROUP . "user");
    }

    /**
     * Returns the password for the user to log into the ftp server
     *
     * @return string
     */
    public function getFtpPass() {
        return Mage::getStoreConfig(self::SECTION . self::FTP_GROUP . "pass");
    }

    /**
     * Returns the host that we will log into via ftp
     *
     * @return string
     */
    public function getFtpHost() {
        return Mage::getStoreConfig(self::SECTION . self::FTP_GROUP . "host");
    }

    /**
     * Returns the path on the ftp server that we will drop the feed into
     *
     * @return string
     */
    public function getFtpPath() {
        return Mage::getStoreConfig(self::SECTION . self::FTP_GROUP . "path");
    }

    /**
     * Returns the javascript that goes into the html head block
     *
     * @return string
     */
    public function getHeaderJs() {
        return Mage::getStoreConfig(self::SECTION . self::JS_GROUP . "header");
    }

    /**
     * Returns the javascript that goes into the before_body_end
     *
     * @return string
     */
    public function getFooterJs() {
        return Mage::getStoreConfig(self::SECTION . self::JS_GROUP . "footer");
    }

    /**
     * Returns the javascript that goes under the mini search form to provide
     * autocomplete features from SLI
     *
     * @return string
     */
    public function getAutocompleteJs() {
        return Mage::getStoreConfig(self::SECTION . self::JS_GROUP . "autocomplete");
    }

    /**
     * Returns the external search domain to the SLI externally hosted search page
     *
     * @return string
     */
    public function getSearchDomain() {
        return Mage::getStoreConfig(self::SECTION . self::JS_GROUP . "domain");
    }

    /**
     * Returns the email to send notifications to when the cron runs
     *
     * @return string
     */
    public function getCronEmail() {
        return Mage::getStoreConfig(self::SECTION . self::CRON_GROUP . "email");
    }

    /**
     * Returns the frequency that the cron should run.
     *
     * @return string
     */
    public function getCronFrequency() {
        return Mage::getStoreConfig(self::SECTION . self::CRON_GROUP . "frequency");
    }

    /**
     * Returns the time of day that the cron should run at.
     *
     * @return string
     */
    public function getCronTime() {
        return Mage::getStoreConfig(self::SECTION . self::CRON_GROUP . "time");
    }

    /**
     * Returns an array of attributes to be included in the feed
     *
     * @return array
     */
    public function getAttributes() {
        $attrs = Mage::getStoreConfig(self::SECTION . self::ATTR_GROUP . "attributes", Mage::app()->getStore()->getId());
        $default_attributes = Mage::getStoreConfig(self::SECTION . self::DEFAULT_ATTRS . "attributes", Mage::app()->getStore()->getId());

        $defaults = array();

        foreach(explode(',',$default_attributes) as $attr) {
            if($attr && trim($attr) != '') $defaults[] = array('attribute'=>trim($attr));
        }

        if($attrs){
            return array_merge($defaults, $attrs);
        }
        else{
            return $defaults;
        }
    }


    /**
     * Return crontab formatted time for cron set time.
     *
     * @param string $frequency
     * @param array $time
     * @return string
     */
    public function getCronTimeAsCrontab($frequency, $time) {
        list($hours, $minutes, $seconds) = $time;

        $cron = array("*", "*", "*", "*", "*");

        //Parse through time
        if ($minutes) {
            $cron[0] = $minutes;
        }

        if ($hours) {
            $cron[1] = $hours;
        }

        //Parse through frequencies
        switch ($frequency) {
            case "W":
                $cron[4] = 0;
                break;
            case "M":
                $cron[2] = 1;
                break;
        }

        return implode(" ", $cron);
    }

    /**
     * Gets the next run date based on cron settings.
     *
     * @return Zend_Date
     */
    public function getNextRunDateFromCronTime() {
        $now = Mage::app()->getLocale()->date();
        $frequency = $this->getCronFrequency();
        list($hours, $minutes, $seconds) = explode(',', $this->getCronTime());

        $time = Mage::app()->getLocale()->date();
        $time->setHour($hours)->setMinute($minutes)->setSecond($seconds);

        //Parse through frequencies
        switch ($frequency) {
            case "D":
                if ($time->compare($now) == -1) {
                    $time->addDay(1);
                }
                break;
            case "W":
                $time->setWeekday(7);
                if ($time->compare($now) == -1) {
                    $time->addWeek(1);
                }
                break;
            case "M":
                $time->setDay(1);
                if ($time->compare($now) == -1) {
                    $time->addMonth(1);
                }
                break;
        }

        return $time;
    }

    function mtime() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

     /**
     * Returns domain(s) as a js var
     *
     * @return url
     */
    public function getSLIDomainJs() {
        $searchURL = $this->getSearchDomain();
        $scheme = parse_url($searchURL, PHP_URL_SCHEME);
        if (!$scheme) {
            $searchURL = "http://".$searchURL;
        }
        preg_match('/http(s|):\/\/(.+?)\//',$searchURL,$matches);
        $searchURLBase = $searchURL;
        if (isset($matches[2])) {
                $searchURLBase = $matches[2];
        }
        $returnJS = "\n<script type=\"text/javascript\">\nvar slibaseurlsearch = '" . $searchURL ."';\nvar slibaseurl = '" . $searchURLBase . "';\n</script>\n";

        return $returnJS;
    }


}