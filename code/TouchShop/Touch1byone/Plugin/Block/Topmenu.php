<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/7/18
 * Time: 5:47 PM
 */

namespace TouchShop\Touch1byone\Plugin\Block;


use Magento\Framework\Data\Tree;
use Magento\Framework\Data\Tree\Node;
use Magento\Framework\Data\Tree\NodeFactory;
use Magento\Framework\UrlInterface;

class Topmenu
{

    /** @var NodeFactory */
    protected $nodeFactory;

    /** @var UrlInterface */
    private $urlBuilder;


    public function __construct(NodeFactory $nodeFactory, UrlInterface $urlBuilder)
    {
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $urlBuilder;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    )
    {
        //remove all children
//        $this->removeChildren($subject);
        $root = $subject->getMenu();
        $this->createNodeTree($root->getTree(), $root, $this->getTopmenuArray());
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

    private function removeChildren(\Magento\Theme\Block\Html\Topmenu $subject)
    {
        $children = $subject->getMenu()->getChildren();
        foreach ($children as $child) {
            $subject->getMenu()->removeChild($child);
        }
    }

    private function getTopmenuArray()
    {
        return [
            'Brand:blog.html' => [
                'Blog:blog.html',
                'Testimony:testimony',
                'Products:products'
            ],
//            'Community:community',
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