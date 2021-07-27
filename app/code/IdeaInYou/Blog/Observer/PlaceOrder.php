<?php

namespace IdeaInYou\Blog\Observer;

use IdeaInYou\Review\Api\ReviewRepositoryInterface;
use IdeaInYou\Review\Model\ReviewFactory;
use Magento\Sales\Model\Order;

class PlaceOrder implements \Magento\Framework\Event\ObserverInterface
{
    private ReviewFactory $reviewFactory;
    private ReviewRepositoryInterface $reviewRepository;

    public function __construct(
        ReviewFactory $reviewFactory,
        ReviewRepositoryInterface $reviewRepository
    ) {
        $this->reviewFactory = $reviewFactory;
        $this->reviewRepository = $reviewRepository;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        /** @var Order $order */
        $order = $observer->getData('order');
        $orderItems = $order->getItems();

        $review = $this->reviewFactory->create()
            ->setAuthor('Admin')
            ->setContent('Review for order #' . $order->getIncrementId())
            ->setProductId(array_pop($orderItems)->getProductId());

        $this->reviewRepository->save($review);

        return $this;
    }


}
