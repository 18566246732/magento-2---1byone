var config = {
    paths: {
        'owlcarousel': "TouchShop_Basic/js/owl.carousel.min",
        'twbsPagination' : "TouchShop_Basic/js/jquery.twbsPagination.min",
        'bootstrap' : "TouchShop_Basic/js/bootstrap.min",
        'simplePagination' : "TouchShop_Basic/js/jquery.simplePagination",
        'dotdotdot': 'TouchShop_Basic/js/jquery.dotdotdot',
        'ajax' : 'TouchShop_Basic/js/ajax',
        'bindQuickAutoLogin' : 'TouchShop_Basic/js/bindQuickAutoLogin'

    },
    shim: {
        'owlcarousel': {
            deps: ['jquery', "bootstrap"]
        },
        'bootstrap' : {
            deps: ['jquery']
        },
        'twbsPagination' : {
            deps: ['jquery']
        },
        'simplePagination' : {
            deps: ['jquery']
        },
        'dotdotdot' : {
            deps: ['jquery']
        },
        'ajax' : {
            deps: ['jquery']
        },
        'bindQuickAutoLogin' : {
            deps: ['jquery', 'ajax']
        }
    }
};