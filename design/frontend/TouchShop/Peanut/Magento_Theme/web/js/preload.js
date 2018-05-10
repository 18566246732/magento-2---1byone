define(['jquery'], function ($) {
    return function (imgArr) {
        if(imgArr instanceof Array) {
            for(x in imgArr) {
                let image = new Image();
                image.src = imgArr[x];
            }
        }
    }
});