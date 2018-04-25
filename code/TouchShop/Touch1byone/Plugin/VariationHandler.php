<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/25/18
 * Time: 3:03 AM
 */

namespace TouchShop\Touch1byone\Plugin;

use Magento\Catalog\Model\Product\Type as ProductType;
use Magento\Framework\Exception\LocalizedException;

class VariationHandler extends \Magento\ConfigurableProduct\Model\Product\VariationHandler
{

    private $attributes;

    /**
     * Generate simple products to link with configurable
     *
     * @param \Magento\Catalog\Model\Product $parentProduct
     * @param array $productsData
     * @return array
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function generateSimpleProducts($parentProduct, $productsData)
    {
        $generatedProductIds = [];
        $this->attributes = null;
        $productsData = $this->duplicateImagesForVariations($productsData);
        foreach ($productsData as $simpleProductData) {
            $newSimpleProduct = $this->productFactory->create();
            if (isset($simpleProductData['configurable_attribute'])) {
                $configurableAttribute = json_decode($simpleProductData['configurable_attribute'], true);
                unset($simpleProductData['configurable_attribute']);
            } else {
                throw new LocalizedException(__('Configuration must have specified attributes'));
            }

            $this->fillSimpleProductData(
                $newSimpleProduct,
                $parentProduct,
                array_merge($simpleProductData, $configurableAttribute)
            );
            $newSimpleProduct->save();

            $generatedProductIds[] = $newSimpleProduct->getId();
        }
        return $generatedProductIds;
    }


    /**
     * Fill simple product data during generation
     *
     * @param \Magento\Catalog\Model\Product $product
     * @param \Magento\Catalog\Model\Product $parentProduct
     * @param array $postData
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     *
     * @return void
     */
    protected function fillSimpleProductData(
        \Magento\Catalog\Model\Product $product,
        \Magento\Catalog\Model\Product $parentProduct,
        $postData
    )
    {
        $typeId = isset($postData['weight']) && !empty($postData['weight'])
            ? ProductType::TYPE_SIMPLE
            : ProductType::TYPE_VIRTUAL;

        $product->setStoreId(
            \Magento\Store\Model\Store::DEFAULT_STORE_ID
        )->setTypeId(
            $typeId
        )->setAttributeSetId(
            $parentProduct->getNewVariationsAttributeSetId()
        );

        if ($this->attributes === null) {
            $this->attributes = $product->getTypeInstance()->getSetAttributes($product);
        }
        foreach ($this->attributes as $attribute) {
            if ($attribute->getIsUnique() ||
                $attribute->getAttributeCode() == 'url_key' ||
                $attribute->getFrontend()->getInputType() == 'gallery' ||
                $attribute->getFrontend()->getInputType() == 'media_image' ||
                !$attribute->getIsVisible()
            ) {
                continue;
            }

            $product->setData($attribute->getAttributeCode(), $parentProduct->getData($attribute->getAttributeCode()));
        }

        $keysFilter = ['item_id', 'product_id', 'stock_id', 'type_id', 'website_id'];
        $postData['stock_data'] = array_diff_key((array)$parentProduct->getStockData(), array_flip($keysFilter));
        if (!isset($postData['stock_data']['is_in_stock'])) {
            $stockStatus = $parentProduct->getQuantityAndStockStatus();
            $postData['stock_data']['is_in_stock'] = $stockStatus['is_in_stock'];
        }
        $postData = $this->processMediaGallery($product, $postData);
        $postData['status'] = isset($postData['status'])
            ? $postData['status']
            : \Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_ENABLED;
        $product->addData(
            $postData
        )->setWebsiteIds(
            $parentProduct->getWebsiteIds()
        )->setVisibility(
            \Magento\Catalog\Model\Product\Visibility::VISIBILITY_IN_SEARCH
        );
    }

}