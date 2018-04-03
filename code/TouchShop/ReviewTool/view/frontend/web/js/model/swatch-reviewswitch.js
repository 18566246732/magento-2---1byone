/*jshint browser:true jquery:true*/
/*global alert*/
define([
    'jquery',
    'mage/utils/wrapper'
], function ($, wrapper) {
    'use strict';

    return function (targetModule) {

        var updatePrice = targetModule.prototype._UpdatePrice;
        // targetModule.prototype.dynamic = {};
        //
        // $('[data-dynamic]').each(function(){
        //     var code = $(this).data('dynamic');
        //     var value = $(this).html();
        //
        //     targetModule.prototype.dynamic[code] = value;
        // });

        var updatePriceWrapper = wrapper.wrap(updatePrice, function (original) {
            // var dynamic = this.options.spConfig.dynamic;
            // console.log(dynamic);
            // for (var code in dynamic){
            //     if (dynamic.hasOwnProperty(code)) {
            //         var value = "";
            //         var $placeholder = $('[data-dynamic='+code+']');
            //         var allSelected = true;
            //
            //         if(!$placeholder.length) {
            //             continue;
            //         }
            //
            //         for(var i = 0; i<this.options.jsonConfig.attributes.length;i++){
            //             if (!$('div.product-info-main .product-options-wrapper .swatch-attribute.' + this.options.jsonConfig.attributes[i].code).attr('option-selected')){
            //                 allSelected = false;
            //             }
            //         }
            //
            //         if(allSelected){
            //             var products = this._CalcProducts();
            //             value = this.options.jsonConfig.dynamic[code][products.slice().shift()].value;
            //         } else {
            //             value = this.dynamic[code];
            //         }
            //
            //         $placeholder.html(value);
            //     }
            // }
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
                    console.log("res", res);
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