Magento 2 Grezpay Payment Gateway
======================

This plugin belongs to Grezpay payment gateway.

Magento v2.x This is a Magento 2.0 v which is supported by Magento version 2.0.x onward.

Installation and Configuration upload app/code/Grezpaypg (all files and folder) at you server end.

Run below command: php bin/magento module:enable Grezpaypg_Grezpay php bin/magento setup:upgrade php bin/magento setup:static-content:deploy

goto Admin->Store->Configuration->Sales->Payment Method->Grezpay fill details here and save them.

goto Admin->System->Cache Management Clear all Cache.

Now you can collect payment via Grezpay .

Go to Store/Configuration/Sales/Payment Methods/Grezpay

Fill all the required details:

1)Enable:yes

2)Title:Grezpay

3)Merchant Id:Pay Id { Provided by Grezpay }

4)Merchant Key:Salt { Provided by Grezpay }

5)Custom Callback Url:no

6)Transaction Url: For Test:https://uat.grezpay.com/crm/jsp/paymentrequest 
For Live:https://merchant.grezpay.com/crm/jsp/paymentrequest

7)Industry Type Id: Name of your choice

8)Website:Your website Name
