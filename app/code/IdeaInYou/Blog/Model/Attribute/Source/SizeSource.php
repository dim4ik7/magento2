<?php

namespace IdeaInYou\Blog\Model\Attribute\Source;



use IdeaInYou\Review\Model\ResourceModel\Review\CollectionFactory;
use IdeaInYou\Review\Model\ReviewRepository;

use IdeaInYou\Review\Model\Review;

class SizeSource
{
    private CollectionFactory $collectionFactory;
    private ReviewRepository $reviewRepository;

    public function __construct(
        CollectionFactory $collectionFactory,
        ReviewRepository $reviewRepository
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->reviewRepository = $reviewRepository;
    }

    public function getAllOptions($withEmpty = true, $defaultValues = false)
    {
        $options = [];

        foreach ($this->collectionFactory->create() as $review){
            /** @var Review $review */
            $options[] = ['value'=>$review->getId(), 'label' => $review->getAuthor()];
        }

        return $options;
    }

    public function getOptionText($value)
    {
        if (!empty($value)) {
            return $this->reviewRepository->getById($value)->getContent();
        } else {
            return null;
        }
    }

    public function setAttribute()
    {
        return $this;
    }
}

