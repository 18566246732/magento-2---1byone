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

class CategoryHelper
{
    /**
     * @param $repository CategoryRepository
     * @return array
     */
    public static function getCategories($repository)
    {
        $result = [];
        try {
            $root = $repository->get(1);
            $all_products_id = explode(',', $root->getChildren())[0];
            $products_id = explode(',', $repository->get($all_products_id)->getChildren())[0];
            $sub_ids = $repository->get($products_id)->getChildren();
            foreach (explode(',', $sub_ids) as $sub_id) {
                $sub = $repository->get($sub_id);
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