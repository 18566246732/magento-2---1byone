var config = {
    paths: {
        'owlcarousel': "TouchShop_Basic/js/owl.carousel.min",
        'twbsPagination' : "TouchShop_Basic/js/jquery.twbsPagination.min",
        'pagination' : "TouchShop_Basic/js/jquery.simplePagination"
    },
    shim: {
        'owlcarousel': {
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