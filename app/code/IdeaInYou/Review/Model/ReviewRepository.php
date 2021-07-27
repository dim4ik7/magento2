<?php

namespace IdeaInYou\Review\Model;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use IdeaInYou\Review\Model\ResourceModel\Review as ResourceReview;
use \IdeaInYou\Review\Model\ReviewFactory;

class ReviewRepository implements ReviewRepositoryInterface
{
    private ReviewFactory $reviewFactory;
    private ResourceReview $resource;

    public function __construct(
        ReviewFactory $reviewFactory,
        ResourceReview $resource
    ) {
        $this->resource = $resource;
        $this->reviewFactory = $reviewFactory;
    }

    public function getById($id)
    {
        $review = $this->reviewFactory->create();
        $this->resource->load($review, $id);
        if (!$review->getId()) {
            throw new NoSuchEntityException(__('Review with id "%1" does not exist.', $id));
        }
        return $review;
    }

    public function save(Review $review)
    {
        try {
            $this->resource->save($review);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the review: %1',
                $exception->getMessage()
            ));
        }
        return $review;
    }

    public function delete(Review $review)
    {
        try {
            $this->resource->delete($review);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Review: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @param $id
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($id)
    {
        $this->delete($this->getById($id));
    }
}
