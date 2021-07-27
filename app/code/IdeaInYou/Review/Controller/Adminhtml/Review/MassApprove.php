<?php

namespace IdeaInYou\Review\Controller\Adminhtml\Review;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use IdeaInYou\Review\Model\Review;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use IdeaInYou\Review\Model\ResourceModel\Review\CollectionFactory;

/**
 * Class MassDelete
 */
class MassApprove extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;
    private ReviewRepositoryInterface $reviewRepository;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $review) {
            /** @var Review $review */
            $review->setIsApproved(true);
            $this->reviewRepository->save($review);
        }

        $this->messageManager->addSuccessMessage(__('A total of %1 review(s) have been approved.', $collectionSize));

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
