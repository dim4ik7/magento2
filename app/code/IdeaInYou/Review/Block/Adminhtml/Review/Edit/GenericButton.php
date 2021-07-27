<?php
namespace IdeaInYou\Review\Block\Adminhtml\Review\Edit;

use Magento\Backend\Block\Widget\Context;
use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;
    private ReviewRepositoryInterface $reviewRepository;


    /**
     * @param Context $context
     * @param ReviewRepositoryInterface $reviewRepository
     */
    public function __construct(
        Context $context,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->context = $context;
        $this->reviewRepository = $reviewRepository;
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getReviewId()
    {
        try {
            return $this->reviewRepository->getById(
                $this->context->getRequest()->getParam('id')
            )->getId();
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
