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


    public function getCategories()
    {
        $result = [];
        try {
            $all_products_id = $this->storeManager->getStore()->getRootCategoryId();
            $products_id = explode(',', $this->repository->get($all_products_id)->getChildren())[0];
            $sub_ids = $this->repository->get($products_id)->getChildren();
            foreach (explode(',', $sub_ids) as $sub_id) {
                $sub = $this->repository->get($sub_id);
                $result[] = [
                    'value' => $sub->getId(),
                    'label' => $sub->getName()
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

}