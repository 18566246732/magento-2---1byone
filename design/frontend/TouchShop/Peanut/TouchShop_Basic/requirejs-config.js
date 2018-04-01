var config = {
    paths: {
        'owlcarousel': "TouchShop_Basic/js/owl.carousel.min",
        'twbsPagination' : "TouchShop_Basic/js/jquery.twbsPagination.min",
        'bootstrap' : "TouchShop_Basic/js/bootstrap.min",
        'simplePagination' : "TouchShop_Basic/js/jquery.simplePagination",
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
        }
    }
};