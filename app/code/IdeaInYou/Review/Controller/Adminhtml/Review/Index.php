<?php

namespace IdeaInYou\Review\Controller\Adminhtml\Review;

use IdeaInYou\Review\Model\ResourceModel\Review\CollectionFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\View\Result\PageFactory;

/**
 * Index action.
 */
class Index extends \Magento\Backend\App\Action implements HttpGetActionInterface
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'IdeaInYou_Review::content';

    /**
     * @var PageFactory
     */
    protected $resultPageFactory;
    private CollectionFactory $collectionFactory;


    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        CollectionFactory $collectionFactory

    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('IdeaInYou_Review::general');
        $resultPage->getConfig()->getTitle()->prepend(__('Review Total = %1',$this->collectionFactory->create()->count()));



        return $resultPage;
    }
}
