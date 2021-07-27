<?php


namespace IdeaInYou\Review\Controller\Adminhtml\Review;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use IdeaInYou\Review\Model\ReviewFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;

/**
 * Save CMS block action.
 */
class Save extends \Magento\Backend\App\Action implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;
    private Registry $_coreRegistry;
    /**
     * @var ReviewFactory|mixed
     */
    private $reviewFactory;
    /**
     * @var ReviewRepositoryInterface|mixed
     */
    private $reviewRepository;

    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ReviewFactory $reviewFactory = null,
        ReviewRepositoryInterface $reviewRepository = null
    )
    {
        $this->dataPersistor = $dataPersistor;
        $this->reviewFactory = $reviewFactory
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ReviewFactory::class);
        $this->reviewRepository = $reviewRepository
            ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ReviewRepositoryInterface::class);
        parent::__construct($context);
        $this->_coreRegistry = $coreRegistry;
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            /** @var \Magento\Cms\Model\Block $model */
            $model = $this->reviewFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->reviewRepository->getById($id);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('This review no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                $this->reviewRepository->save($model);
                $this->messageManager->addSuccessMessage(__('You saved the review.'));
                $this->dataPersistor->clear('ideainyou_review');
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }

            $this->dataPersistor->set('ideainyou_review', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param \Magento\Cms\Model\Block $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect === 'continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        }
        return $resultRedirect;
    }


}
