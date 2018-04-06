<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/7/18
 * Time: 5:47 PM
 */

namespace TouchShop\Touch1byone\Plugin\Block;


use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Data\Tree;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\Data\TreeFactory;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\Template;

class Topmenu extends \Magento\Theme\Block\Html\Topmenu
{
    /** @var NodeFactory */
    private $nodeFactory;

    /** @var UrlInterface */
    private $urlBuilder;

    /**@var CategoryRepository */
    private $categoryRepository;


    public function __construct(
        UrlInterface $url,
        CategoryRepository $categoryRepository,
        Template\Context $context,
        NodeFactory $nodeFactory,
        TreeFactory $treeFactory,
        array $data = []
    )
    {
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $url;
        $this->categoryRepository = $categoryRepository;
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
    }
//    /**
//     * @param Node $menuTree
//     * @param string $childrenWrapClass
//     * @param int $limit
//     * @param array $colBrakes
//     * @return string
//     * @throws \Magento\Framework\Exception\NoSuchEntityException
//     */
//    protected function _getHtml(
//        \Magento\Framework\Data\Tree\Node $menuTree,
//        $childrenWrapClass,
//        $limit,
//        $colBrakes = []
//    )
//    {
//        $html = parent::_getHtml($menuTree, $childrenWrapClass, $limit, $colBrakes);
//        $parentLevel = $menuTree->getLevel();
//        $childLevel = $parentLevel === null ? 0 : $parentLevel + 1;
//        $menuId = $menuTree->getId();
//
//        if ($childLevel == 1 && $this->isCategory($menuId)) {
//            $html .= '<li class="category_image" style=""><img src="' . $this->getCategoryImage($menuId) . '"/></li>';
//        }
//
//        return $html;
//    }
//
//
//    /**
//     * @param $categoryId
//     * @return mixed
//     * @throws \Magento\Framework\Exception\NoSuchEntityException
//     */
//    protected function getCategoryImage($categoryId)
//    {
//        $categoryIdElements = explode('-', $categoryId);
//        $category = $this->categoryRepository->get(end($categoryIdElements));
//        $categoryName = $category->getImageUrl();
//
//        return $categoryName;
//    }
//
//    /**
//     * Check if current menu element corresponds to a category
//     *
//     * @param string $menuId Menu element composed ID
//     *
//     * @return string
//     */
//    protected function isCategory($menuId)
//    {
//        $menuId = explode('-', $menuId);
//
//        return 'category' == array_shift($menuId);
//    }

    public function getHtml(
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    )
    {
        $root = $this->getMenu();
        $this->createNodeTree($root->getTree(), $root, $this->getTopmenuArray());
        return parent::getHtml($outermostClass, $childrenWrapClass, $limit);
    }

    private function getNodeAsArray($name, $id)
    {
        return [
            'name' => $name,
            'id' => $id,
            'url' => $this->urlBuilder->getUrl($id),
            'has_active' => false,
            'is_active' => false
        ];
    }

    private function getTopmenuArray()
    {
        return [
            'Brand:blog.html' => [
                'Blog:blog.html',
                'Testimony:testimony',
                'Products:products'
            ],
            'Deals:sales' => [
                'Sales:sales',
                'Campaign & Lucky Draw:campaign',
                'Power User:power-user'
            ],
            'Support:refund' => [
                'FAQ & Downloads:support',
                'Refund & Exchange:refund',
                'Feedback:feedback'
            ]
        ];
    }

    private function createNodeTree(Tree $tree, $parent, $children)
    {
        foreach ($children as $key => $value) {
            if (is_integer($key)) {
                $this->createChild($tree, $parent, $value);
            } else {
                $node = $this->createChild($tree, $parent, $key);
                $this->createNodeTree($tree, $node, $value);
            }

        }
    }

    private function createChild(Tree $tree, Node $parent, $value)
    {
        $explodes = explode(':', $value, 2);
        $name = $explodes[0];
        $id = $explodes[1];
        $node = $this->nodeFactory->create(
            [
                'data' => $this->getNodeAsArray($name, $id),
                'idField' => 'id',
                'tree' => $tree

            ]
        );
        $parent->addChild($node);
        return $node;
    }

}