<?php

namespace IdeaInYou\Review\Model;

use IdeaInYou\Review\Api\ReviewInterface;
use Magento\Framework\DataObject\IdentityInterface;

class Review extends \Magento\Framework\Model\AbstractModel implements ReviewInterface, IdentityInterface
{
    const  CACHE_TAG = 'ideainyou_review';

    protected $_eventPrefix = 'ideainyou_review';

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\IdeaInYou\Review\Model\ResourceModel\Review::class);
    }

    /**
     * Get identities
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return parent::getData(self::ENTITY_ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    public function getAuthor()
    {
        return parent::getData(self::AUTHOR);
    }

    public function setAuthor($author)
    {
        return $this->setData(self::AUTHOR, $author);
    }
}
