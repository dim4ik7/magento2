<?php

namespace IdeaInYou\Blog\Controller\Index;

use IdeaInYou\Review\Helper\Data;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

class Display extends Action implements HttpGetActionInterface
{
    private Data $data;

    public function __construct(
        Context $context,
        Data $data
    ) {
        parent::__construct($context);
        $this->data = $data;
    }

    public function execute()
    {
        var_dump($this->data->getTitle());
//        $this->data->dfg();
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
