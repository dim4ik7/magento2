<?php


namespace IdeaInYou\Review\Model\Review;

use IdeaInYou\Review\Model\ResourceModel\Review\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\ModifierPoolDataProvider
{
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $blockCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     * @param PoolInterface|null $pool
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $reviewCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = [],
        PoolInterface $pool = null
    )
    {
        $this->collection = $reviewCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data, $pool);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $review) {
            $this->loadedData[$review->getId()] = $review->getData();
        }

        $data = $this->dataPersistor->get('ideainyou_review');
        if (!empty($data)) {
            $review = $this->collection->getNewEmptyItem();
            $review->setData($data);
            $this->loadedData[$review->getId()] = $review->getData();
            $this->dataPersistor->clear('ideainyou_review');
        }

        return $this->loadedData;
    }
}
