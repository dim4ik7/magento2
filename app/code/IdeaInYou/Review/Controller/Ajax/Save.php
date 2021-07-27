<?php


namespace IdeaInYou\Review\Controller\Ajax;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use IdeaInYou\Review\Model\ReviewFactory;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Json as ResultJson;
use Magento\Framework\Controller\Result\JsonFactory as ResultJsonFactory;
use Magento\Framework\Serialize\Serializer\Json as JsonSerializer;

/**
 * Class Save
 */
class Save implements HttpGetActionInterface
{
    /**
     * @var JsonSerializer
     */
    private JsonSerializer $jsonSerializer;
    /**
     * @var ResultJsonFactory
     */
    private ResultJsonFactory $resultJsonFactory;
    /**
     * @var RequestInterface
     */
    private RequestInterface $request;
    private ReviewFactory $reviewFactory;
    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(
        JsonSerializer $jsonSerializer,
        ResultJsonFactory $resultJsonFactory,
        RequestInterface $request,
        ReviewFactory $reviewFactory,
        ReviewRepositoryInterface $reviewRepository
    )
    {
        $this->jsonSerializer = $jsonSerializer;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->request = $request;
        $this->reviewFactory = $reviewFactory;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * @return ResultJson
     */
    public function execute()
    {
        if (!$this->request->isAjax()) {
            $data = [
                'success' => false,
                'error_message' => __('This is not $.ajax')
            ];

            return $this->resultJsonFactory->create()->setData($data);
        }

        try {
            $requestData = $this->request->getParams();

            $review = $this->reviewFactory->create();
            $review->setData($requestData);

            $this->reviewRepository->save($review);

            $data = [
                'success' => true,
                'error_message' => '',
            ];
        } catch (\Exception $ex) {
            $data = [
                'success' => false,
                'error_message' => $ex->getMessage()
            ];
        }

        return $this->resultJsonFactory->create()->setData($data);
    }
}
