<?php
/**
 * Provide the URL for SLI to retrieve the current shopping cart items and all relative informations
 * An JSON file will be passback
 *
 */
class SLI_Search_ApiController extends Mage_Core_Controller_Front_Action
{
    //Decare the quote
    private $_quote = NULL;
    
    /**
     * Load the quote by passing the quote id
     * 
     * @param int $quoteId
     * @return Mage_Sales_Model_Quote
     */
   private function _getQuote()
    {
        if( $this->_quote ) return $this->_quote;
        else return Mage::getSingleton('checkout/session')->getQuote();
    }
    
    /**
     * Allow SLI to call this url to get the cart jsonp object
     * 
     */
    public function cartAction()
    {
        $jsonpResult = Mage::helper( 'sli_search' )->getCartJSONP( $this->_getQuote() );
        
        if( $jsonpResult )
            $this->getResponse()->setBody( $jsonpResult );
    }
    
	
    
} 