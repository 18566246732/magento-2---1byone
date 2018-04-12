define('ajax', ['jquery'], function ($) {
    function sendAjax(isAsync, url, param, ajaxHandler) {
        console.log("sendAjax in");
        $.ajax({
            url: url,
            type: "POST",
            data: param,
            async: isAsync,
            success: function (res) {
                console.log("ajax ok");
                console.log("res", res);
                ajaxHandler(res);
            },
            error: function (jqXHR, textstatus, errorThrown) {
                console.log(jqXHR, textstatus, errorThrown);
                console.log("ajax error");
            }
        });
    }
    return {sendAjax : sendAjax}
})

