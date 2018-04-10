(function () {
    require(['jquery', 'dotdotdot'], function ($) {
        $(function () {
            var proItem = $(".product-items .product-item");
            var reviewsSummary = $(".product-reviews-summary.short");
            // var proItemLink = $(".product-items .product-item .product-item-link");
            var proItemLink = $(".product-item-link");
            proItem.each(function (index, e) {
                if($(e).find(".product-reviews-summary").length === 0) {
                    $(e).find(".product-item-name").css("padding-bottom", "25px");
                }
            });
            proItemLink.each(function (index, e) {
                // console.log("e.txt.length:", $(e).text().trim().length);
                // $clamp(e,{clamp: 2});
                $(e).dotdotdot();
                // if($(e).text().length >= (60 + 78)) {
                //     $(e).parent().addClass("p-i-n");
                // }
            });
        })
    })
})()