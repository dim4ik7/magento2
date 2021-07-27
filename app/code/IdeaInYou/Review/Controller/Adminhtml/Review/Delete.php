<?php
namespace IdeaInYou\Review\Controller\Adminhtml\Review;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;

/**
 * Class MassDelete
 */
class Delete extends \Magento\Backend\App\Action implements HttpPostActionInterface
{

    private ReviewRepositoryInterface $reviewRepository;

    /**
     * @param Context $context
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(
        Context $context,
        ReviewRepositoryInterface $reviewRepository
    ) {
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

        $reviewId = $this->getRequest()->getParam('id');

        if ($reviewId){
            try {
                $this->reviewRepository->deleteById($reviewId);
                $this->messageManager->addSuccessMessage(__('Review (ID: %1) have been deleted.', $reviewId));
            } catch (\Exception $exception){
                $this->messageManager->addErrorMessage($exception->getMessage());
            }

        }


        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
