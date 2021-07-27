<?php

namespace IdeaInYou\Blog\Controller\FirstPage;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Catalog index page controller.
 */
class Index extends Action implements HttpGetActionInterface
{

    public function execute()
    {
        return  $this->resultFactory->create(ResultFactory::TYPE_PAGE);

    }
}
