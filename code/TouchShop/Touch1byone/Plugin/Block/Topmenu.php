<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/7/18
 * Time: 5:47 PM
 */

namespace TouchShop\Touch1byone\Plugin\Block;


use Magento\Catalog\Model\CategoryRepository;
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

    public function getTopMenus()
    {
        return [
            [
                "label" => 'Brand',
                'url' => $this->getUrl('blog.html'),
                'image_url' => $this->getMediaUrl('brand_top.png'),
                'submenus' => [
                    [
                        "label" => 'Blog',
                        'url' => $this->getUrl('blog.html'),
                        'image_url' => $this->getMediaUrl('blog_top.png'),
                    ], [
                        "label" => 'Testimony',
                        'url' => $this->getUrl('testimony'),
                        'image_url' => $this->getMediaUrl('testimony_top.png'),

                    ], [
                        "label" => 'Products',
                        'url' => $this->getUrl('products'),
                        'image_url' => $this->getMediaUrl('products_top.png'),
                    ]
                ]
            ],
            [
                "label" => 'Deals',
                'url' => $this->getUrl('deals'),
                'image_url' => $this->getMediaUrl('deals_top.png'),
                'submenus' => [
                    [
                        "label" => 'Sales',
                        'url' => $this->getUrl('sales'),
                        'image_url' => $this->getMediaUrl('sales_top.png'),
                    ], [
                        "label" => 'Campaign & Lucky Draw',
                        'url' => $this->getUrl('campaign'),
                        'image_url' => $this->getMediaUrl('campaign_top.png'),

                    ], [
                        "label" => 'Power User',
                        'url' => $this->getUrl('poweruser'),
                        'image_url' => $this->getMediaUrl('power_user_top.png'),
                    ]
                ]
            ],
            [
                "label" => 'Support',
                'url' => $this->getUrl('support'),
                'image_url' => $this->getMediaUrl('support_top.png'),
                'submenus' => [
                    [
                        "label" => 'FAQ & Download',
                        'url' => $this->getUrl('support'),
                        'image_url' => $this->getMediaUrl('support_top.png'),
                    ], [
                        "label" => 'Refund & Exchange',
                        'url' => $this->getUrl('refund'),
                        'image_url' => $this->getMediaUrl('refund_top.png'),

                    ], [
                        "label" => 'Feedback',
                        'url' => $this->getUrl('feedback'),
                        'image_url' => $this->getMediaUrl('feedback_top.png'),
                    ]
                ]
            ]
        ];
    }

    public function getMediaUrl($filename)
    {
        return $this->getBaseUrl() . 'pub/media/home_page/' . $filename;
    }
}