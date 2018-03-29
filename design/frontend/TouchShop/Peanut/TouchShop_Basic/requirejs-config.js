var config = {
    paths: {
        'owlcarousel': "TouchShop_Basic/js/owl.carousel.min",
        'twbsPagination' : "TouchShop_Basic/js/jquery.twbsPagination.min",
        'pagination' : "TouchShop_Basic/js/jquery.simplePagination",
        'bootstrap' : "TouchShop_Basic/js/bootstrap.min.js"
    },
    shim: {
        'owlcarousel': {
            deps: ['jquery']
        },
        'twbsPagination' : {
            deps: ['jquery', 'bootstrap']
        },
        'pagination' : {
            deps: ['jquery']
        },
        'bootstrap' : {
            deps: ['jquery']
        }
    }
};