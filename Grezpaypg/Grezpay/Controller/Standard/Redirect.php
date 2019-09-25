<?php

namespace Grezpaypg\Grezpay\Controller\Standard;

class Redirect extends \Grezpaypg\Grezpay\Controller\Grezpay
{
    public function execute()
    {
        $promo='';
        if(isset($_GET['promo'])){
            if(trim($_GET['promo'])!=''){
                $promo=$_GET['promo'];
            }
        }
        $order = $this->getOrder();
        if ($order->getBillingAddress())
        {
            $order->setState("pending_payment")->setStatus("pending_payment");
            $order->addStatusToHistory($order->getStatus(), "Customer was redirected to grezpay.");
            $order->save();
            
            if($promo!=''){
                $order->grezpayPromoCode=$promo;
            }

            $this->getResponse()->setRedirect(
                $this->getGrezpayModel()->buildGrezpayRequest($order)
            );
        }
        else
        {
            $this->_cancelPayment();
            $this->_grezpaySession->restoreQuote();
            $this->getResponse()->setRedirect(
                $this->getGrezpayHelper()->getUrl('checkout')
            );
        }
    }
}