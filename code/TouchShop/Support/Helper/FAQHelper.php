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
                    $question_labels = ['Question:', 'question:', 'q:', 'Q：', 'Question：', 'question：', 'q：', 'Q：'];
                    $answer_labels = ['Answer:', 'answer:', 'a:', 'A:', 'Answer：', 'answer：', 'a：', 'A：'];
                    foreach (preg_split(self::LINE_BREAK_PATTERN, $question) as $index => $qa) {
                        if ($index == 0) {
                            $item['question'] = self::getContent($qa, $question_labels);
                        } elseif ($index == 1) {
                            $item['answer'] = self::getContent($qa, $answer_labels);
                        } else {
                            $item['answer'] .= "<br/>" . $qa;
                        }
                    }
                    $results[] = $item;
                }
                return $results;
            }
        }

        return [];
    }

    private static function getContent($qa, $labels)
    {
        foreach ($labels as $label) {
            $len = strlen($label);
            if (strlen($qa) > $len) {
                $head = substr($qa, 0, $len);
                if ($head === $label) {
                    return substr($qa, $len);
                }
            }
        }
        return '';
    }

}