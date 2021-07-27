<?php

namespace IdeaInYou\Review\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    const ENABLE_CONFIG_PATH = 'review/general/enable';
    const TITLE_CONFIG_PATH = 'review/general/title';

    public function getEnabled(): bool
    {
        return (bool) $this->scopeConfig->getValue(self::ENABLE_CONFIG_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->scopeConfig->getValue(self::TITLE_CONFIG_PATH,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

//    public function dfg(){
//
//        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
//        $cart = $objectManager->get('\Magento\Checkout\Model\Cart');
//        $itemsCollection = $cart->getQuote()->getItemsCollection();
//        $itemVisible= $cart->getQuote()->getAllVisibleItems();
//       return $this->scopeConfig->getValue('blog/index/display',
//            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
//
//
//    }
}
