<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/10/18
 * Time: 12:10 AM
 */

namespace TouchShop\Touch1byone\Block;


use Magento\Catalog\Model\ResourceModel\Category\Collection;
use Magento\Catalog\Block\Adminhtml\Category\Tree;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Model\Category;

class CategoryNavigator extends Template
{

    /**@var Collection */
    private $collection;

    /** @var Tree */
    private $tree;


    public function __construct(
        Collection $collection,
        Tree $tree,
        Template\Context $context,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->collection = $collection;
        $this->tree = $tree;
    }

    private function resolve($tree)
    {
        $result = [];
        $result['text'] = $tree['text'];
        if (isset($tree['id'])) {
            /**@var Category $category */
            $category = $this->collection->getItemById($tree['id']);
            $result['url'] = $category->getUrl();
        }
        if (isset($tree['children'])) {
            $result['children'] = [];
            foreach ($tree['children'] as $index => $child) {
                $child = $this->resolve($child);
                $result['children'][$index] = $child;
            }
        }
        return $result;
    }

    public function getImgBaseUrl($img_urlName)
    {
        return $this->getBaseUrl() . 'pub/media/icon/' . $img_urlName;
    }

    public function getCategoryTree()
    {
        $tree = $this->tree->getTree();
        $result = $this->resolve($tree[0]);
        return json_encode($result);
    }
}