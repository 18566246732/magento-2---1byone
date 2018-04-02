/**
 * Created by jing on 2017-01-30.
 */

var config = {
    config: {
        mixins: {
            'Magento_ConfigurableProduct/js/configurable': {
                'TouchShop_ReviewTool/js/model/reviewswitch': true
            },
            'Magento_Swatches/js/swatch-renderer': {
                'TouchShop_ReviewTool/js/model/swatch-reviewswitch': true
            }
        }
    }
};