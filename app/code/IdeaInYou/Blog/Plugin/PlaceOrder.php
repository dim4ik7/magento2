<?php

namespace IdeaInYou\Blog\Plugin;

use Magento\Sales\Model\Order;

class PlaceOrder
{

    public function afterPlace(Order $subject)
    {
       $subject->hold();
       $subject->save();
    }


}
