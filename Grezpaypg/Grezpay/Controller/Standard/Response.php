<?php
namespace Grezpaypg\Grezpay\Controller\Standard;

class Response extends \Grezpaypg\Grezpay\Controller\Grezpay
{
    public function execute()
    {
		$comment = "";
        $request = $_POST;

		$returnUrl = $this->getGrezpayHelper()->getUrl('/');
		$orderId = $_POST['ORDER_ID'];
		$orderTXNID = $_POST['TXN_ID'];
		$orderTotal = $_POST['AMOUNT']/100;

		$orderStatus = $_POST['STATUS'];
       if ($request['STATUS']=="Captured") {
   
 $order = $this->getOrderById($orderId);
 $order->setState(\Magento\Sales\Model\Order::STATE_PROCESSING);
		$order->setStatus($order::STATE_PROCESSING);
		$order->setExtOrderId($orderId);
		$order->save();
		$returnUrl = $this->getGrezpayHelper()->getUrl('checkout/onepage/success');
        $this->getResponse()->setRedirect($returnUrl); 

       }
	else{

        $this->_cancelPayment();
        $this->_checkoutSession->restoreQuote();
        $this->getResponse()->setRedirect(
        $this->getGrezpayHelper()->getUrl('checkout')
        );
	    }

	}
}
