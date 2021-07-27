<?php

namespace IdeaInYou\Review\Controller\Adminhtml\Review;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use IdeaInYou\Review\Model\ReviewFactory;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\PageFactory;

/**
 * Edit CMS block action.
 */
class Edit extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    protected PageFactory $resultPageFactory;
    private Registry $_coreRegistry;
    private ReviewFactory $reviewFactory;
    private ReviewRepositoryInterface $reviewRepository;

    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        PageFactory $resultPageFactory,
        ReviewFactory $reviewFactory,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
        $this->reviewFactory = $reviewFactory;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Edit CMS block
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');



        // 2. Initial checking
        if ($id) {
            try {
                $model = $this->reviewRepository->getById($id);
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage($exception->getMessage());
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        } else {
            $model = $this->reviewFactory->create();
        }

        $this->_coreRegistry->register('ideainyou_review', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? __('Review: %1', $model->getId()) : __('New Review'));
        return $resultPage;
    }
}
