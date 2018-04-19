define(['jquery'],function ($) {
    return {
        stopScroll: function () {
            function disabledMouseWheel() {
                if (document.addEventListener) {
                    document.addEventListener('DOMMouseScroll', scrollFunc, false);
                }//W3C
                window.onmousewheel = document.onmousewheel = scrollFunc;//IE/Opera/Chrome
            }
            function scrollFunc(evt) {
                return false;
            }
            window.onload=disabledMouseWheel;
        },
        resumeScroll: function () {

        }




        //禁用滚轮
        function disabledMouseWheel() {
        if (document.addEventListener) {
            document.addEventListener('DOMMouseScroll', scrollFunc, false);
        }//W3C
        window.onmousewheel = document.onmousewheel = scrollFunc;//IE/Opera/Chrome
    }

    //开启滚轮
    function scrollFunc(evt) {
        evt = evt || window.event;
        if(evt.preventDefault) {
            // Firefox
            evt.preventDefault();
            evt.stopPropagation();
        } else {
            // IE
            evt.cancelBubble=true;
            evt.returnValue = false;
        }
        return false;
    }
    window.onload=disabledMouseWheel;


}
})