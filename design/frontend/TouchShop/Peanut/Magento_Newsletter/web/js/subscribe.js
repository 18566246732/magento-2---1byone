define(['jquery'], function ($) {
    return function (baseUrl, urlArr, hoverUrlArr) {
        $('.iconfont').each(function (index, e) {
            $(e).css("background-image", 'url('+ baseUrl + urlArr[index]+')');
            $(e).hover(function () {
                $(this).css("background-image", 'url('+ baseUrl + hoverUrlArr[index] + ')');
            }, function () {
                $(this).css("background-image", 'url('+ baseUrl + urlArr[index] + ')');
            });
        });
    }
})