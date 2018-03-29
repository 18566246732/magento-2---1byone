var config = {
    paths: {
        'owlcarousel': "TouchShop_Basic/js/owl.carousel.min",
        'twbsPagination' : "TouchShop_Basic/js/jquery.twbsPagination.min",
        'pagination' : "TouchShop_Basic/js/jquery.simplePagination",
        'bootstrap' : "TouchShop_Basic/js/bootstrap.min",
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
        'pagination' : {
            deps: ['jquery']
        }
    }
};