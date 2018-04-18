define(['jquery'], function ($) {
    return function (baseUrl, urlArr) {
        $('.iconfont').each(function (index, e) {
            $(e).css("background-image", 'url('+ baseUrl + urlArr[index]+')');
        });
        console.log("socials:", $(".socials"));
    }
})