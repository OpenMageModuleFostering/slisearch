<?php
/**
 * Helper class to render the JSONP object for SLI
 *  
 */
class SLI_CartInfo_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     * Render the cart grand total and total item within the cart
     * @param Mage_Sales_Model_Quote $quote
     * @return array
     */
    private function _renderCartTotal( $quote )
    {       
        if( !$quote ) return false;
        
        //Declare the array container
        $cartInfoArray = array();
        $quoteItemCount = $quote->getItemsCount();
                
        //Store the item count to array
        $cartInfoArray['NumberOfItems'] = $quoteItemCount;
        
        $totals = $quote->getTotals();
        if( $totals )
        {
            if( $totals['grand_total'] )
                $cartInfoArray['TotalPrice'] = $totals['grand_total']->getValue();
            
            if( $totals['tax'] )
            $cartInfoArray['TotalGST'] = $totals['tax']->getValue();            
        }
        
        //Get The Cart Total Discount Amount
        $items = $quote->getAllVisibleItems();
        $itemDiscount = 0;
        foreach( $items as $item )
        {
            if( !$item ) continue;
            $itemDiscount += $item->getDiscountAmount();
        }
        $cartInfoArray['TotalDiscount'] = $itemDiscount;
        
        //Get The Delivery Cost if applicable
        $shippingCost = $quote->getShippingAddress()->getShippingAmount(); 
        $shippingCostTax = $quote->getShippingAddress()->getShippingTaxAmount();
        if($shippingCost == (float)0){
            $cartInfoArray['DeliveryCost'] = 0;
        }else{
            $cartInfoArray['DeliveryCost'] = (float)$shippingCost + (float)$shippingCostTax;
        }
        
        return $cartInfoArray;
    }
    
    /**
     * Render the cart item detail
     * @param Mage_Sales_Model_Quote $quote
     * @return array
     */
    private function _renderItemsDetail( $quote )
    {
        //Array of items
        $itemsArray = array();
        if( !$quote ) return false;
        
        $items = $quote->getAllVisibleItems();
        
        foreach( $items as $item )
        {
            if( !$item ) continue;
            
            //Declare an array to store item information
            $itemInfo = array();
            $itemProduct = $item->getProduct();
            
            $itemInfo[ 'title' ] = $item->getName();
            $itemInfo[ 'sku' ] = $item->getSku();
            $itemInfo[ 'qty' ] = $item->getQty();            
            //Get the item Product Object
            $product = $item->getProduct();
            //Get the original price for item product
            $itemInfo[ 'price' ] = $product->getPrice();
            //Get the sale price      
            $itemInfo[ 'sale_price' ] = $item->getPriceInclTax(); 
            
            $itemInfo[ 'item_url' ] = $this->getItemUrl($item);
            $itemInfo[ 'remove_url' ] = Mage::getUrl('checkout/cart/delete/', array('id'=>$item->getId()));            
            $itemInfo[ 'image_url' ] = Mage::getModel('catalog/product_media_config')->getMediaUrl($itemProduct->getThumbnail());             
            
            $itemsArray[] = $itemInfo;
        }        
        return $itemsArray;
    }

    /**
     * Get the item url
     * @param cart item
     * @return string
     */
    
    public function getItemUrl($item)
    {
        if ($item->getRedirectUrl()) {
            return $item->getRedirectUrl();
        }
        
        $product = $item->getProduct();
        $option  = $item->getOptionByCode('product_type');
        if ($option) {
            $product = $option->getProduct();
        }
        return $product->getUrlModel()->getUrl($product);
            
    }
    
    
    /**
     * Render the JSONP object for SLI
     * 
     * @param Mage_Sales_Model_Quote $quote
     * @return string
     */
    public function getCartJSONP( $quote )
    {
    	$form_key['form_key'] = Mage::getSingleton('core/session')->getFormKey();
        $cart = $this->_renderCartTotal( $quote );
        $items = $this->_renderItemsDetail( $quote );
        
        $result = array_merge($form_key, $cart, $items);
        $jsonResult = json_encode( $result );        
        //Wrap up as jsonp object
        $jsonpResult = "sliCartRequest($jsonResult)";
        return $jsonpResult;
    }
	
}