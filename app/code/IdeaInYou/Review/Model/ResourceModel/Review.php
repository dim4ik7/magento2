<?php

namespace IdeaInYou\Review\Model\ResourceModel;

use IdeaInYou\Review\Api\ReviewInterface;

class Review extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected function _construct()
    {
        $this->_init(ReviewInterface::TABLE_NAME, ReviewInterface::ENTITY_ID);
    }
}
