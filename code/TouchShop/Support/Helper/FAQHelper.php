<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/20/18
 * Time: 1:34 AM
 */

namespace TouchShop\Support\Helper;


use Magento\Catalog\Model\Product;

class FAQHelper
{
    const DOUBLE_LINE_BREAK_PATTERN = '/\r\n\r\n|\r\r|\n\n/';
    const LINE_BREAK_PATTERN = '/\r\n|\r|\n/';

    public static function getFAQ(Product $product)
    {
        $product_faq = $product->getCustomAttribute('product_faq');
        if ($product_faq) {
            $faq = $product_faq->getValue();
            if ($faq) {
                $results = [];
                foreach (preg_split(self::DOUBLE_LINE_BREAK_PATTERN, $faq) as $question) {
                    $item = [];
                    foreach (preg_split(self::LINE_BREAK_PATTERN, $question) as $qa) {
                        if (strlen($qa) > 2) {
                            $head = substr($qa, 0, 2);
                            $tail = substr($qa, 2);
                            if ($head === 'Q:') {
                                $item['question'] = $tail;
                            } elseif ($head == 'A:') {
                                $item['answer'] = $tail;
                            }
                        }
                    }
                    $results[] = $item;
                }
                return $results;
            }
        }

        return [];
    }

}