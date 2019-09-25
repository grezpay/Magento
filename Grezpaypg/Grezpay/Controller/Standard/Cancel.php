<?php

namespace Grezpaypg\Grezpay\Controller\Standard;

class Cancel extends \Grezpaypg\Grezpay\Controller\Grezpay
{

    public function execute()
    {
        $this->_cancelPayment();
        $this->_checkoutSession->restoreQuote();
        $this->getResponse()->setRedirect(
            $this->getGrezpayHelper()->getUrl('checkout')
        );
    }

}
