<?php


namespace IdeaInYou\Review\Model\ResourceModel\Review;

use IdeaInYou\Review\Model\Review;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            Review::class,
            \IdeaInYou\Review\Model\ResourceModel\Review::class
        );
    }


    public function asd()
    {
        $this->addFieldToFilter('entity_id', ['neq'=>'2']);
        $this->getData();
    }


}
