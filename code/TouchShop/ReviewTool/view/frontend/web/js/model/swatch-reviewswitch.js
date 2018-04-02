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
            let product_id_updated = item.val();
            if (product_id_updated !== product_id) {
                //todo
                console.log('updating ', product_id);
                item.val(product_id)
            }


            return original();
        });

        targetModule.prototype._UpdatePrice = updatePriceWrapper;
        return targetModule;

    };
});