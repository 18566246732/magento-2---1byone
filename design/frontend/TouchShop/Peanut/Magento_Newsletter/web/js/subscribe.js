define(['jquery'], function ($) {
    return function (baseUrl, urlArr, hoverUrlArr) {

        $('.iconfont1').each(function (index, e) {
            $(e).css("background-image", 'url(' + baseUrl + urlArr[index] + ')');
            $(e).hover(function () {
                $(this).css("background-image", 'url(' + baseUrl + hoverUrlArr[index] + ')');
            }, function () {
                $(this).css("background-image", 'url(' + baseUrl + urlArr[index] + ')');
            });
        });

        $(function () {
            $('.iconfont2').each(function (index, e) {
                $(e).css("background-image", 'url(' + baseUrl + hoverUrlArr[index] + ')');
            })
        })
    }
});