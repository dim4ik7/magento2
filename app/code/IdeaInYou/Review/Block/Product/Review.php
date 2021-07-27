<?php

namespace IdeaInYou\Review\Block\Product;

use IdeaInYou\Review\Model\ResourceModel\Review\CollectionFactory;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\Context;

/**
 * Class Review
 * @package IdeaInYou\Review\Block\Product
 */
class Review extends \Magento\Catalog\Block\Product\View
{
    private CollectionFactory $collectionFactory;

    public function __construct(
        Context $context,
        \Magento\Framework\Url\EncoderInterface $urlEncoder,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Framework\Stdlib\StringUtils $string,
        \Magento\Catalog\Helper\Product $productHelper,
        \Magento\Catalog\Model\ProductTypes\ConfigInterface $productTypeConfig,
        \Magento\Framework\Locale\FormatInterface $localeFormat,
        \Magento\Customer\Model\Session $customerSession,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        CollectionFactory $collectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $urlEncoder, $jsonEncoder, $string, $productHelper, $productTypeConfig, $localeFormat, $customerSession, $productRepository, $priceCurrency, $data);
        $this->collectionFactory = $collectionFactory;
    }

    public function getReviews()
    {
        $productId = $this->getProduct()->getId();

        return  $this->collectionFactory->create()
            ->addFieldToFilter('is_approved', ['eq' => 1])
            ->addFieldToFilter('product_id', $productId);
    }

    public function getIsLoggedIn()
    {
        return $this->customerSession->isLoggedIn();
    }

    public function getCurrentCustomer() {
        return $this->customerSession->getCustomer();
    }
}
