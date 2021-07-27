<?php


/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace IdeaInYou\Review\Ui\Component\Listing\Column;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Escaper;

/**
 * Class to build edit and delete link for each item.
 */
class Product extends Column
{
    /** Url path */
    const PRODUCT_EDIT_URL = 'catalog/product/edit';

    /** @var UrlInterface */
    protected $urlBuilder;
    private ProductRepositoryInterface $productRepository;

    /**
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        ProductRepositoryInterface $productRepository,
        array $components = [],
        array $data = []
    )
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->productRepository = $productRepository;
    }

    /**
     * Prepare Data Source.
     *
     * @param array $dataSource
     *
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $name = $this->getData('name');
                if (isset($item['entity_id'])) {
                    $item[$name] = html_entity_decode('<a href="' . $this->urlBuilder->getUrl(
                        self::PRODUCT_EDIT_URL,
                        ['id' => $item['product_id']]
                        ) . '" target="_blank">' . $this->productRepository->getById($item['product_id'])->getName() . '</a>');
                }
            }
        }

        return $dataSource;
    }
}
