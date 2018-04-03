(function () {
    require(['jquery'], function ($) {
        $(function () {
            var proItem = $(".product-items .product-item");
            var reviewsSummary = $(".product-reviews-summary.short");
            var proItemLink = $(".product-items .product-item .product-item-link");
            proItem.each(function (index, e) {
                if($(e).find(".product-reviews-summary").length === 0) {
                    $(e).find(".product-item-name").css("padding-bottom", "25px");
                }
            });
            proItemLink.each(function (index, e) {
                console.log($(e).text().length, $(e).text());
                if($(e).text().length >= (60 + 78)) {
                    $(e).parent().addClass("p-i-n");
                }
            })
        })
    })
})()