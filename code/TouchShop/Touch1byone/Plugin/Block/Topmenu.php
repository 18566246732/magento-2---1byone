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
use Magento\Framework\Exception\NoSuchEntityException;
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

    private $media_base_url;


    public function __construct(
        UrlInterface $url,
        CategoryRepository $categoryRepository,
        Template\Context $context,
        NodeFactory $nodeFactory,
        TreeFactory $treeFactory,
        array $data = []
    )
    {
        parent::__construct($context, $nodeFactory, $treeFactory, $data);
        $this->nodeFactory = $nodeFactory;
        $this->urlBuilder = $url;
        $this->categoryRepository = $categoryRepository;
        $this->media_base_url = $this->_storeManager->getStore()->getBaseUrl('media');
    }

    // top in top menu
    private function resolve()
    {
        $result = [];
        try {
            $root = $this->categoryRepository->get(1);
            $main_root_ids = $root->getChildren();
            if (strpos($main_root_ids, ',') === false) {
                $main_root = $this->categoryRepository->get($main_root_ids);
                $main_top_ids = $main_root->getChildren();
                foreach (explode(',', $main_top_ids) as $menu_id) {
                    $menu = $this->categoryRepository->get($menu_id);
                    $menu_data = [
                        'label' => $menu->getName(),
                        'url' => $menu->getUrl(),
                        'image_url' => $this->getImageUrl($menu)
                    ];
                    $sub_menu_ids = $menu->getChildren();
                    $sub_menus_data = [];
                    foreach (explode(',', $sub_menu_ids) as $sub_menu_id) {
                        $sub_menu = $this->categoryRepository->get($sub_menu_id);
                        $sub_menus_data[] = [
                            'label' => $sub_menu->getName(),
                            'url' => $sub_menu->getUrl(),
                            'image_url' => $this->getImageUrl($sub_menu)
                        ];
                    }
                    $menu_data['submenus'] = $sub_menus_data;
                    $result[] = $menu_data;
                }
            }

        } catch (NoSuchEntityException $e) {
        }
        return $result;

    }

    private function getProductsUrl()
    {
        try {
            $root = $this->categoryRepository->get(1);
            $main_root_ids = $root->getChildren();
            if (strpos($main_root_ids, ',') === false) {
                $main_root = $this->categoryRepository->get($main_root_ids);
                $main_top_ids = $main_root->getChildren();
                $id = explode(',', $main_top_ids)[0];
                return $this->categoryRepository->get($id)->getUrl();
            }
        } catch (\Exception $e) {
        }
    }

    public function getTopMenus()
    {
//        $result = $this->resolve();

        $result = [];
        $to_merge = [
            [
                'label' => 'Product',
                'url' => $this->getProductsUrl(),
                'image_url' => $this->getMediaUrl('product_top.png'),
                'submenus' => [
                    [[
                        'label' => 'TV Accessories',
                        'url' => $this->getUrl('all-products/tv-accessories.html'),
                        'image_url' => $this->getMediaUrl('tv_accessories_top.png'),
                    ], [
                        'label' => 'Audio',
                        'url' => $this->getUrl('all-products/audio-sounds.html'),
                        'image_url' => $this->getMediaUrl('audio_top.png'),
                    ], [
                        'label' => 'Health',
                        'url' => $this->getUrl('all-products/chargers.html'),
                        'image_url' => $this->getMediaUrl('health_top.png'),
                    ], [
                        'label' => 'Home Security',
                        'url' => $this->getUrl('all-products/home-security.html'),
                        'image_url' => $this->getMediaUrl('home_security_top.png'),
                    ], [
                        'label' => 'Kitchen',
                        'url' => $this->getUrl('all-products/kitchen.html'),
                        'image_url' => $this->getMediaUrl('kitchen_top.png'),
                    ]], [[
                        'label' => 'Beauty',
                        'url' => $this->getUrl('all-products/beauty.html'),
                        'image_url' => $this->getMediaUrl('beauty_top.png'),
                    ], [
                        'label' => '3c & Accessories',
                        'url' => $this->getUrl('all-products/3c-accessories.html'),
                        'image_url' => $this->getMediaUrl('3c_accessories_top.png'),
                    ], [
                        'label' => 'Outdoors',
                        'url' => $this->getUrl('all-products/outdoors.html'),
                        'image_url' => $this->getMediaUrl('outdoors_top.png'),
                    ], [
                        'label' => 'Household',
                        'url' => $this->getUrl('all-products/household.html'),
                        'image_url' => $this->getMediaUrl('household_top.png'),
                    ]],
                ],
                'additions' => [
                    [
                        'label' => '1byone',
                        'url' => $this->getUrl('1byone-brand.html'),
                    ], [
                        'label' => 'Naturalife',
                        'url' => $this->getUrl('naturalife.html'),
                    ], [
                        'label' => 'Simple Taste',
                        'url' => $this->getUrl('simple-taste.html')
                    ], [
                        'label' => 'Beautural',
                        'url' => $this->getUrl('beautural.html')
                    ]
                ]
            ], [
//                "label" => 'Deals',
//                'url' => $this->getUrl('sales'),
//                'image_url' => $this->getMediaUrl('deals_top.png'),
//                'submenus' => [[]]
//            ], [
                'label' => 'Community',
                'url' => $this->getUrl('blog.html'),
                'image_url' => $this->getMediaUrl('brand_top.png'),
                'submenus' => [
                    [[
                        "label" => 'Blog',
                        'url' => $this->getUrl('blog.html'),
                        'image_url' => $this->getMediaUrl('blog_top.png'),
                    ], [
                        "label" => 'Customer Story',
                        'url' => $this->getUrl('customer-story'),
                        'image_url' => $this->getMediaUrl('customer_story_top.png'),

                    ], [
                        "label" => 'Super User',
                        'url' => $this->getUrl('poweruser'),
                        'image_url' => $this->getMediaUrl('power_user_top.png'),
                    ]]
                ]
            ], [
                "label" => 'Support',
                'url' => $this->getUrl('support'),
                'image_url' => $this->getMediaUrl('support_top.png'),
                'submenus' => [
                    [[
                        "label" => 'FAQ & Downloads',
                        'url' => $this->getUrl('support'),
                        'image_url' => $this->getMediaUrl('downloads_top.png'),
                    ], [
                        "label" => 'Product Warranty',
                        'url' => $this->getUrl('warranty'),
                        'image_url' => $this->getMediaUrl('warranty_top.png'),
                    ], [
                        "label" => 'Refund & Exchange',
                        'url' => $this->getUrl('refund'),
                        'image_url' => $this->getMediaUrl('refund_top.png'),

                    ], [
                        "label" => 'Feedback',
                        'url' => $this->getUrl('feedback'),
                        'image_url' => $this->getMediaUrl('feedback_top.png'),
                    ]]
                ]
            ]];
        return array_merge($result, $to_merge);
    }

    private function getMediaUrl($filename)
    {
        return $this->media_base_url . 'home_page/' . $filename;
    }

}