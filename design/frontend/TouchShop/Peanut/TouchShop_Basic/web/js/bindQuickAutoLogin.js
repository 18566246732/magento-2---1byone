

define('bindQuickAutoLogin', ['jquery', 'ajax'], function ($, ajax) {
    /**
     * @param data
     * @param baseUrl
     * @param email
     * @param userPwd1Con
     * @param userPwd2Con
     * @param userPwd1
     * @param userPwd2
     * @param formActionInput
     * @param submitBtn
     * @param hint
     * @param submitFormFunc
     */
    function bindQuickAutoLogin(
                                data,
                                baseUrl,
                                email,
                                userPwd1Con,
                                userPwd2Con,
                                userPwd1,
                                userPwd2,
                                formActionInput,
                                submitBtn,
                                hint,
                                submitFormFunc) {
        let vip = data.vip;
        let vip1 = -1;
        let emailRegExp = new RegExp('^[a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\\.[a-zA-Z0-9_-]+)+$');
        var customerId = data.customerId;
        console.log("data:", data, "vip:", vip, "customerId: ", customerId);
        if (vip > 0) {
            email.attr({"value": data.email, "readonly": "readonly"});
        } else {
            email.blur(function () {
                    console.log('blur');
                    if (!emailRegExp.test(email.val())) {
                        hint.text("invalid email format");
                        return false;
                    }
                    console.log("email blured");
                    let url = baseUrl + 'basic/account/hasSignUp';
                    let param = {
                        email: email.val()
                    };
                    ajax.sendAjax(false, url, param, function (res) {
                            vip1 = res.vip;
                            console.log("vip1", vip1);
                            //display logic
                            if (vip1 == 0) {
                                hint.text("You haven't registered yet, quickly sign up and submit your form");
                                userPwd1Con.css("display", "block");
                                userPwd2Con.css("display", "block");
                                userPwd1.val("");
                                userPwd2.val("");
                            } else {
                                userPwd1Con.css("display", "block");
                                userPwd2Con.css("display", "none");
                                userPwd1.val("");
                                hint.text("You have already registered, quickly sign in and submit your form");
                            }
                        }
                    )
                }
            );

            email.focus(function () {
                hint.text(" ");
            });
        }

        $(document).keypress(function (e) {
            if(e.which == 13 && formActionInput.is(":focus")) {
                if(e.target == email[0]) {
                    email.trigger("blur");
                } else {
                    formSubmitHandler();
                }
            }
        });

        email.on("keyup", function () {
            if (vip == 0) {
                vip1 = -1;
                userPwd1Con.css("display", "none");
                userPwd2Con.css("display", "none");
            }
        });

        submitBtn.click(formSubmitHandler);

        function formSubmitHandler(e) {
            if (vip == 0 && vip1 == -1) {
                return false;
            }
            if (vip == 0) {
                if (vip1 == 0) {
                    //register
                    console.log("vip1:", vip1);//todo
                    if (!register()) {
                        return false;
                    }
                    console.log("register success");//todo
                }
                //login
                //vip1 = 1 or 2
                console.log("vip1:", vip1);//todo
                if (!login()) {
                    return false;
                }
                console.log("login success");//todo
            }
            console.log("before submit");//todo
            //sendajax submit form
            let submitFornRes = submitFormFunc(email.val(), customerId);
            console.log("after submit", submitFornRes);//todo
            if (submitFornRes) {
                console.log("location:", location);
                location.reload();
            }
        }

        function register() {
            let result = false;
            console.log("p1:", userPwd1.val(), "p2:", userPwd2.val());
            if (userPwd1.val() != userPwd2.val()) {
                hint.text("2 passwords should be equal");
                return false;
            }
            let param = {
                email: email.val(),
                firstname: 'customer',
                lastname: 'user',
                password: userPwd1.val()
            };
            let url = baseUrl + 'basic/account/createPost';
            ajax.sendAjax(false, url, param, function (res) {
                console.log(res);
                if (res.status_code == 200) {
                    result = true
                } else {
                    hint.text(res.error_message);
                }
            });
            return result;
        }

        function login() {
            let result = false;
            let param = {
                login: {
                    username: email.val(),
                    password: userPwd1.val()
                }
            };
            let url = baseUrl + 'basic/account/signInPost';
            ajax.sendAjax(false, url, param, function (res) {
                console.log(res);
                if (res.status_code == 200) {
                    customerId = res.customerId;
                    result = true;
                } else {
                    hint.text(res.error_message);
                }
            });
            return result;
        }

    }

    return {
        bind: bindQuickAutoLogin
    }
})