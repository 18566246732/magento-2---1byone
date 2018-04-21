<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/11/18
 * Time: 8:31 PM
 */

namespace TouchShop\ProductTool\Helper;


use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Store\Model\StoreManagerInterface;

class CategoryHelper
{

    private $categoryData = null;

    /**@var CategoryRepository */
    private $repository;
    private $storeManager;

    public function __construct(
        StoreManagerInterface $storeManager,
        CategoryRepository $categoryRepository
    )
    {
        $this->repository = $categoryRepository;
        $this->storeManager = $storeManager;
    }

    public function getCategoryData()
    {
        $products = [];
        $brands = [];
        if ($this->categoryData == null) {
            try {
                $rootCategoryId = $this->storeManager->getStore()->getRootCategoryId();
                $products_id = explode(',', $this->repository->get($rootCategoryId)->getChildren());
                $len = count($products_id);
                if ($len >= 1) {
                    $productsRootId = $products_id[0];
                    $sub_ids = $this->repository->get($productsRootId)->getChildren();
                    foreach (explode(',', $sub_ids) as $sub_id) {
                        $sub = $this->repository->get($sub_id);
                        $products[] = [
                            'value' => $sub->getId(),
                            'label' => $sub->getName(),
                            'url' => $sub->getUrl()
                        ];
                    }

                }

                if ($len >= 2) {
                    $brands_id = array_slice($products_id, 1);
                    foreach ($brands_id as $brand_id) {
                        $brandCategory = $this->repository->get($brand_id);
                        $brands[] = [
                            'label' => $brandCategory->getName(),
                            'url' => $brandCategory->getUrl()
                        ];
                    }
                }


            } catch (NoSuchEntityException $e) {
            }
        }

        return [
            'products' => $products,
            'brands' => $brands
        ];
    }


    public function getCategories()
    {
        $result = [];
        try {
            $rootCategoryId = $this->storeManager->getStore()->getRootCategoryId();
            $products_id = explode(',', $this->repository->get($rootCategoryId)->getChildren())[0];
            $sub_ids = $this->repository->get($products_id)->getChildren();
            foreach (explode(',', $sub_ids) as $sub_id) {
                $sub = $this->repository->get($sub_id);
                $result[] = [
                    'value' => $sub->getId(),
                    'label' => $sub->getName(),
                ];
            }

        } catch (NoSuchEntityException $e) {
            return $result;
        }
        $result[] = [
            'value' => 0,
            'label' => 'Other'
        ];
        return $result;
    }

    public function getBrands()
    {
        $brands = [];
        try {
            $rootCategoryId = $this->storeManager->getStore()->getRootCategoryId();
            $products_id = explode(',', $this->repository->get($rootCategoryId)->getChildren());
            if (count($products_id) > 2) {
                $brands_id = array_slice($products_id, 1);
                foreach ($brands_id as $brand_id) {
                    $brandCategory = $this->repository->get($brand_id);
                    $brands[] = [
                        'label' => $brandCategory->getName(),
                        'url' => $brandCategory->getUrl()
                    ];
                }
            }
        } catch (\Exception $e) {
            return $brands;
        }
        return $brands;
    }

}