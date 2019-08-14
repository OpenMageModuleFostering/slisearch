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
 * Generates feed file based on store
 *
 * @package SLI
 * @subpackage Search
 */
class SLI_Search_Model_Feed extends Mage_Core_Model_Abstract {

    protected $_ajaxNotice = "Currently generating feeds...";
    protected $_dbConnection = null;

    protected $_totalProductCount = null;

    /**
     * Generate feed based on store and returns success
     *
     * @return boolean 
     */
    public function generateFeed($price_feed = false) {
        try {
            if (!$price_feed) {
                return PHP_EOL."If you had the full version of Learning Search Connect, this would have created a feed containing up to {$this->_getProductCount()} products.".PHP_EOL."Please Contact SLI to receive the full version. Call us toll free in the US: (866) 240-2812 or send us an email to sales@sli-systems.com".PHP_EOL.PHP_EOL;
            }
        } catch (Exception $e) {
            Mage::log("Exception: {$e->getMessage()}");
        }
    }

    /**
     * Returns the total number of products in the store catalog
     *
     * @return int
     */
    protected function _getProductCount() {
        if ($this->_totalProductCount === null) {          
            $count = $this->_getConnection()->query("select count(entity_id) from ".Mage::getSingleton('core/resource')->getTableName('catalog/product'));
            $this->_totalProductCount = ($count) ? $count->fetch(PDO::FETCH_COLUMN) : 0;
        }
        return $this->_totalProductCount;
    }

    /**
     * Returns the database connection used by the feed
     *
     * @return PDO
     */
    protected function _getConnection() {
        if (!$this->_dbConnection) {
            $connection = Mage::getConfig()->getNode('global/resources/default_setup/connection');
            $name = $connection->dbname;
            $host = $connection->host;
            $user = $connection->username;
            $pass = $connection->password;

            $this->_dbConnection = new PDO("mysql:dbname=$name;host=$host", $user, $pass);
        }
        $this->_dbConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this->_dbConnection;
    }    

    public function getAjaxNotice() {
        $this->_ajaxNotice = "<p style='color:red'>If you had the full version of Learning Search Connect, this would have created a feed containing up to {$this->_getProductCount()} products. Please Contact SLI to receive the full version. Call us toll free in the US: (866) 240-2812 or send us an email to sales@sli-systems.com</p>";
        return $this->_ajaxNotice;
    }    
}
