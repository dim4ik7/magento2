<?php

namespace IdeaInYou\Blog\Block;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use IdeaInYou\Review\Model\ResourceModel\Review\CollectionFactory;
use IdeaInYou\Review\Model\ReviewFactory;
use Magento\Framework\View\Element\Template;

class Hello extends \Magento\Framework\View\Element\Template
{
    private ReviewFactory $reviewFactory;
    private CollectionFactory $collectionFactory;
    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(
        ReviewFactory $reviewFactory,
        ReviewRepositoryInterface $reviewRepository,
        CollectionFactory $collectionFactory,
        Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->reviewFactory = $reviewFactory;
        $this->collectionFactory = $collectionFactory;
        $this->reviewRepository = $reviewRepository;
    }

    protected function _prepareLayout()
    {
        $this->pageConfig->getTitle()->set('My First Blog in first.loc');
        return parent::_prepareLayout();
    }

    public function getHelloMessage()
    {
        return 'hello from block';
    }

    public function getReviewCollection()
    {
        return $this->collectionFactory->create();
    }

    public function getReviewById($reviewId)
    {
        return $this->reviewRepository->getById($reviewId);
    }



    public function createReview() {
        $review = $this->reviewFactory->create();
        $review->setAuthor('sss')
            ->setProductId(1)
            ->setContent('zxczxcasd' . time());
        $this->reviewRepository->save($review);
    }


}
