define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'grezpay',
                component: 'Grezpaypg_Grezpay/js/view/payment/method-renderer/grezpaypg-grezpay'
            }
        );
        return Component.extend({});
    }
 );