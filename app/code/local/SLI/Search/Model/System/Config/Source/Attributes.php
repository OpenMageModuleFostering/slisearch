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
 * Source renderer for product attributes data.
 * 
 * @package SLI
 * @subpackage Search
 */

class SLI_Search_Model_System_Config_Source_Attributes {


    //These attributes are automatically included in the feed and thus dont need
    //to be selectable on the configuration
    protected $_automaticAttributes = array('name', 'url_path', 'status', 'type_id');

    /**
     * We want these attributes to appear in the drop down configuration menu, but they are not included in the
     * EAV selection. We must add them in individually.
     * if a key exists for a value, that key will be used as the label instead of the prefixed value
     *
     * @var array
     */
    protected $_nonEavAttributes = array(
        'product_id',
        'type_id',
        'max_price',
        'min_price',
        'parent_ids' => 'parent_id',
    );

    /**
     * Prefix to use in the dropdown to differentiate the inventory attributes
     */
    const INVENTORY_ATTRIBUTES_PREFIX = 'inventory';

    /**
     * Attributes from the flat inventory table that we will use for the feed
     * if a key exists for a value, that key will be used as the label instead of the prefixed value
     *
     * @var array
     */
    protected $_inventoryAttributes = array(
        'qty',
        'is_in_stock',
        'manage_stock',
        'backorders',
    );

    /**
     * Prefix to use in the dropdown to differentiate the review attributes
     */
    const REVIEW_ATTRIBUTES_PREFIX = 'review';

    /**
     * Attributes from customer review that we will use for the feed
     * if a key exists for a value, that key will be used as the label instead of the prefixed value
     *
     * @var array
     */
    protected $_reviewAttributes = array(
        'reviews_count' => 'reviews_count',
        'rating_summary',
    );

    /**
     * Returns code => code pairs of attributes for all product attributes
     *
     * @return array
     */
    public function toOptionArray() {
        $productEntityId = Mage::getModel('eav/entity_type')->loadByCode('catalog_product')->getId();

        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')
        ->setEntityTypeFilter($productEntityId);
        $attributes->getSelect()->reset(Zend_Db_Select::COLUMNS)->columns(array("code" => 'attribute_code'));

        foreach ($attributes as $attribute) {
            $code = $attribute['code'];
            if (!in_array($attribute['code'], $this->_automaticAttributes)) {
                $options[$code] = $code;
            }
        }

        // We want some non-eav attributes to be added to this dropdown as well
        foreach ($this->_nonEavAttributes as $label => $attributeCode) {
            $label = is_string($label) ? $label : $attributeCode;
            $options[$attributeCode] = $label;
        }

        // Add the inventory attributes
        foreach ($this->_inventoryAttributes as $label => $attributeCode) {
            $code = self::INVENTORY_ATTRIBUTES_PREFIX . "_" . $attributeCode;
            $label = is_string($label) ? $label : self::INVENTORY_ATTRIBUTES_PREFIX . "_" . $attributeCode;
            $options[$code] = $label;
        }

        // Add the review attributes
        foreach ($this->_reviewAttributes as $label => $attributeCode) {
            $code = self::REVIEW_ATTRIBUTES_PREFIX . "_" . $attributeCode;
            $label = is_string($label) ? $label : self::REVIEW_ATTRIBUTES_PREFIX . "_" . $attributeCode;
            $options[$code] = $label;
        }

        // Sort the array to account for the non-eav attrs being added in
        asort($options);
        
        unset($options['price']);  //remove price from multiselect since it will be included regardless
        return $options;
    }
}