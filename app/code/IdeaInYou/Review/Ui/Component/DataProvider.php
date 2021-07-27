<?php

namespace IdeaInYou\Review\Ui\Component;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\DataProvider\Reporting;

class DataProvider extends \Magento\Cms\Ui\Component\DataProvider
{
    private ProductRepositoryInterface $productRepository;
    private \Magento\Framework\UrlInterface $urlBuilder;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        Reporting $reporting,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        RequestInterface $request,
        FilterBuilder $filterBuilder,
        ProductRepositoryInterface $productRepository,
        \Magento\Framework\UrlInterface $urlBuilder,
        array $meta = [],
        array $data = [],
        array $additionalFilterPool = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $reporting, $searchCriteriaBuilder, $request, $filterBuilder, $meta, $data, $additionalFilterPool);
        $this->productRepository = $productRepository;
        $this->urlBuilder = $urlBuilder;
    }
}
