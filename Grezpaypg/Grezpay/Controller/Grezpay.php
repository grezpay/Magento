<?php

namespace Grezpaypg\Grezpay\Controller;

abstract class Grezpay extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Grezpay\Model\Session
     */
    protected $_checkoutSession;

    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    protected $_orderFactory;

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    protected $_logger;

    /**
     * @var \Magento\Quote\Model\Quote
     */
    protected $_quote = false;

    protected $_GrezpayModel;

    protected $_GrezpayHelper;
	
	protected $_orderHistoryFactory;


    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Checkout\Model\Session $checkoutSession
     * @param \Magento\Sales\Model\OrderFactory $orderFactory
     * @param \Grezpaypg\grezpay\Model\grezpay $twogrezpayModel
     * @param \Grezpaypg\grezpay\Helper\grezpay $grezpayHelper
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Checkout\Model\Session $checkoutSession,
        \Magento\Sales\Model\OrderFactory $orderFactory,
		\Magento\Sales\Model\Order\Status\HistoryFactory $orderHistoryFactory,
        \Grezpaypg\Grezpay\Model\Grezpay $grezpayModel,
        \Grezpaypg\Grezpay\Helper\Data $grezpayHelper,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->_customerSession = $customerSession;
        $this->_checkoutSession = $checkoutSession;
        $this->_orderFactory = $orderFactory;
        $this->_logger = $logger;
		$this->_orderHistoryFactory = $orderHistoryFactory;
        $this->_grezpayModel = $grezpayModel;
        $this->_grezpayHelper = $grezpayHelper;		
        parent::__construct($context);
    }



    /**
     * Cancel order, return quote to customer
     *
     * @param string $errorMsg
     * @return false|string
     */
    protected function _cancelPayment($errorMsg = '')
    {
        $gotoSection = false;
        $this->_grezpayHelper->cancelCurrentOrder($errorMsg);
        if ($this->_checkoutSession->restoreQuote()) {
            //Redirect to payment step
            $gotoSection = 'paymentMethod';
        }

        return $gotoSection;
    }

    /**
     * Get order object
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function getOrderById($order_id)
    {
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $order = $objectManager->get('Magento\Sales\Model\Order');
        $order_info = $order->loadByIncrementId($order_id);
        return $order_info;
    }

    /**
     * Get order object
     *
     * @return \Magento\Sales\Model\Order
     */
    protected function getOrder()
    {
        return $this->_orderFactory->create()->loadByIncrementId(
            $this->_checkoutSession->getLastRealOrderId()
        );
    }

	protected function addOrderHistory($order,$comment){
		$history = $this->_orderHistoryFactory->create()
			->setComment($comment)
            ->setEntityName('order')
            ->setOrder($order);
			$history->save();
		return true;
	}
	
    protected function getQuote()
    {
        if (!$this->_quote) {
            $this->_quote = $this->_getCheckoutSession()->getQuote();
        }
        return $this->_quote;
    }

    protected function getCheckoutSession()
    {
        return $this->_checkoutSession;
    }

    protected function getCustomerSession()
    {
        return $this->_customerSession;
    }

    protected function getGrezpayModel()
    {
        return $this->_grezpayModel;
    }

    protected function getGrezpayHelper()
    {
        return $this->_grezpayHelper;
    }
}
