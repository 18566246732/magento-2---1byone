<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/6/18
 * Time: 12:39 AM
 */

namespace TouchShop\ReviewTool\Block;


use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use TouchShop\ProductTool\Helper\ProductHelper;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollectionFactory;

class Reviews extends Template
{
    private $registry;
    private $productCollectionFactory;
    private $reviewAdvancedCollectionFactory;
    private $manager;

    public function __construct(
        Registry $registry,
        CollectionFactory $productCollectionFactory,
        ReviewAdvancedCollectionFactory $reviewAdvancedCollectionFactory,
        ManagerInterface $manager,
        Template\Context $context,
        array $data = [])
    {
        $this->registry = $registry;
        $this->manager = $manager;
        $this->productCollectionFactory = $productCollectionFactory;
        $this->reviewAdvancedCollectionFactory = $reviewAdvancedCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getAction()
    {
        return $this->getUrl('reviews');
    }

    public function isChecked($time, $value)
    {
        return $time == $value ? 'checked' : '';
    }


    public function getChartData()
    {
        $post = $this->registry->registry('postData');
        if (!isset($post['asin']) || !$post['time']) {
            $post = [
                'asin' => '',
                'time' => 7
            ];
        }
        if (!$post['asin']) {
            $product_id = null;
        } else {
            $product_id = $this->getProductIdByAsin($post['asin']);
            if (!$product_id) {
                $this->manager->addErrorMessage('No such asin: ' . $post['asin']);
                return null;
            }
        }


        $time = intval($post['time']);

        $data = [];
        $y_labels = [];
        $seconds_per_day = 86400;
        $date_format = 'Y-m-d';

        for ($days_before = $time; $days_before > 0; $days_before--) {
            $date_before = date($date_format, time() - $days_before * $seconds_per_day);
            for ($star = 1; $star <= 5; $star++) {
                $collection = $this->reviewAdvancedCollectionFactory->create();
                $collection->addFieldToFilter('star', $star);
                $collection->addFieldToFilter('date', $date_before);
                if ($product_id) {
                    $collection->addFieldToFilter('product_id', $product_id);
                }
                $data[$star][] = $collection->getSize();
            }
            $y_labels[] = $date_before;
        }

        $positive = [];
        $critical = [];
        $average = [];
        $totals = [
            1 => 0,
            2 => 0,
            3 => 0,
            4 => 0,
            5 => 0
        ];
        for ($index = 0; $index < $time; $index++) {
            $critical[] = $data[1][$index] + $data[2][$index] + $data[3][$index];
            $positive[] = $data[4][$index] + $data[5][$index];
            $sum = 0;
            $count = 0;
            for ($star = 1; $star <= 5; $star++) {
                $num = $data[$star][$index];
                $sum += $star * $num;
                $count += $num;
                $totals[$star] += $num;
            }
            $average[] = $count ? $sum / $count : 0;
        }


        return [
            'post' => $post,
            'data' => [
                'Grading trend map' => [
                    'data' => [
                        '1 star' => $data[1],
                        '2 stars' => $data[2],
                        '3 stars' => $data[3],
                        '4 stars' => $data[4],
                        '5 stars' => $data[5],
                        'positive' => $positive,
                        'critical' => $critical
                    ],
                    'y' => $y_labels
                ],
                'star' => [
                    'data' => [
                        'average' => $average
                    ],
                    'y' => $y_labels
                ],
                'star ratio' => [
                    'data' => [
                        ['1 star', $totals[1]],
                        ['2 stars', $totals[2]],
                        ['3 stars', $totals[3]],
                        ['4 stars', $totals[4]],
                        ['5 stars', $totals[5]],
                    ],
                    'y' => $y_labels
                ]
            ]
        ];
    }

    private function getProductIdByAsin($asin)
    {
        $collection = $this->productCollectionFactory->create()->addAttributeToFilter(
            ProductHelper::AMAZON_ASIN, $asin
        )->load();
        if ($collection->getSize() > 0) {
            return current(array_keys($collection->getItems()));
        }
        return null;

    }
}