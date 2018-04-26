/**
 * please set hint underline the input ,textarea, select element before you using this object, and do remember to hide them using css first
 * @formValidater TouchShop_Touch1byone/js/formValidate
 *
 * */

define(['jquery'], function ($) {
    return formValidater = {
        resetAreaForm: function (node) {
            var areaFormEle = node.find("input, textarea, select");
            areaFormEle.css("border", "1px solid #c2c2c2");
            node.find(".hint").hide();
        },
        validateForm: function (form) {
            var formEle = form.find("input, textarea, select");
            console.log(form.find("input, textarea, select"));
            formEle.each(function (index, e) {
                console.log(e, "required:", $(e).attr("required"));
                if ($(e).attr("required")) {
                    if (!$(e).val() && $(e).val() != " ") {
                        $(e).css("border", "1px solid red");
                        $(e).next().show();
                    } else {
                        $(e).css("border", "1px solid #c2c2c2");
                        $(e).next().hide();
                    }
                }
            });
        }
    }
})