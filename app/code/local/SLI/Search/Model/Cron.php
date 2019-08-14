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
 * Cron activities for the sli feed generation
 *
 * @package SLI
 * @subpackage Search
 */
class SLI_Search_Model_Cron {

    /**
     * Generates the feeds and sends email of status when done
     */
    public function generateFeeds() {
        try {
            Mage::helper('sli_search/feed')->generateFeedsForAllStores();
            $msg = "Feeds Generating";
        }
        catch (SLI_Search_Exception $e) {
            $msg = $e->getMessage();
        }
        catch (Exception $e) {
            $msg = "Unknown Error: {$e->getMessage()} in {$e->getFile()} on line {$e->getLine()}. Please contact your sli provider.";
        }

        $this->_sendEmail($msg);
    }

    /**
     * If there is a system config email set, send out the cron notification
     * email.
     */
    protected function _sendEmail($msg) {
        Mage::getModel('sli_search/email')->setData('msg', "test")->send();
    }
}