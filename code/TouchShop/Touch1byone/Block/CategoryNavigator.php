<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/10/18
 * Time: 12:10 AM
 */

namespace TouchShop\Touch1byone\Block;


use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class CategoryNavigator extends Template
{

    /** @var CategoryRepository */
    private $repository;
    private $currentCategoryId;


    public function __construct(
        Registry $registry,
        CategoryRepository $repository,
        Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->repository = $repository;
        $this->currentCategoryId = $this->getCurrentCategoryId($registry);
    }

    public function getImgBaseUrl($img_urlName)
    {
        return $this->getBaseUrl() . 'pub/media/icon/' . $img_urlName;
    }

    private function resolve($category)
    {
        $result = [
            'text' => $category->getName(),
            'url' => $category->getUrl()
        ];

        if ($category->getId() == $this->currentCategoryId) {
            $result['current'] = true;
        }

        $subs = $category->getChildren();
        foreach (explode(',', $subs) as $sub) {
            try {
                $sub_category = $this->repository->get($sub);
                $result['children'][] = $this->resolve($sub_category);
            } catch (NoSuchEntityException $e) {
            }
        }
        return $result;
    }

    public function getCategoryTree()
    {
        try {
            $root = $this->repository->get(1);
            $main_root_ids = $root->getChildren();
            if (strpos($main_root_ids, ',') === false) {
                $main_root = $this->repository->get($main_root_ids);
                $resolved = $this->resolve($main_root);
                $result = $resolved['children'][0];
                return json_encode($result);
            }
        } catch (NoSuchEntityException $e) {
        }
        return [];
    }

    private function getCurrentCategoryId($registry)
    {
        $category = $registry->registry('current_category');
        if ($category && $category->getId()) {
            return $category->getId();
        }
        return 0;
    }

}