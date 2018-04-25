define(['jquery'], function ($) {
    return function () {
        var filterTitle = $(".filter-options-item");
        filterTitle.each(function (index, e) {
            if ($(e).find(".filter-options-title").text() == "Category") {
                $(e).addClass("active allow");
                let catagory = $(e).find(".filter-options-content");
                let title = $(e).find(".filter-options-title");
                console.log(catagory, title);
                catagory.addClass("force-open");
                // $(e).off("click");
                // title.off("click");
                $(e).on("click",function () {
                    catagory.toggleClass("force-open");
                    catagory.css("display", "none");
                    $(this).toggleClass("active allow");
                })
            }
        });
    }
})