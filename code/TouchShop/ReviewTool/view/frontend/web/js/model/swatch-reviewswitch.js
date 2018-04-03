/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (targetModule) {

        var updatePrice = targetModule.prototype._UpdatePrice;
        var updatePriceWrapper = wrapper.wrap(updatePrice, function (original) {

            let product_id = this._CalcProducts().slice().shift();
            let item = $("#productIdValue");
            let last_product_id = item.val();
            let url = window.location;
            let baseUrl = url.protocol + "//" + url.hostname + "/" + url.pathname.split('/')[1] + '/';
            let ajaxUrl = baseUrl + 'reviews/ajax/reviewList';
            console.log("baseUrl", baseUrl);
            if (last_product_id !== product_id) {

                console.log('updating ', product_id);
                item.val(product_id);

                $.post(ajaxUrl, {
                    id: product_id,
                    page_num: 1,
                    page_size: 10
                }, function (res) {
                    $("#product-review-container").html(res);
                }).error(function (xhr, status, info) {
                    console.log(xhr, status, info);
                });
            }
            return original();
        });

        targetModule.prototype._UpdatePrice = updatePriceWrapper;
        return targetModule;

    };
});