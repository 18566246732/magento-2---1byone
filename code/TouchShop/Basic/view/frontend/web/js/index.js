(function () {
    require(['jquery'], function ($) {
        $(function () {
            var proItem = $(".product-items .product-item");
            var reviewsSummary = $(".product-reviews-summary.short");
            var proItemLink = $(".product-items .product-item .product-item-link");
            console.log("proItemName:", proItem);
            proItem.each(function (index, e) {
                // console.log($(e).next().hasClass("product-reviews-summary"));
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