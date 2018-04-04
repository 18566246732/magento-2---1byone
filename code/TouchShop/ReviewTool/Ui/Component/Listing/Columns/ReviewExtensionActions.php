<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/1/18
 * Time: 4:51 PM
 */

namespace TouchShop\ReviewTool\Ui\Component\Listing\Columns;


use Magento\Ui\Component\Listing\Columns\Column;

class ReviewExtensionActions extends Column
{
    /**
     * {@inheritdoc}
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$this->getData('name')]['edit'] = [
                'href' => $this->context->getUrl(
                    'reviews/product/edit',
                    ['extension_id' => $item['extension_id']]
                ),
                'label' => __('Edit Review'),
                'hidden' => false,
            ];
        }

        return $dataSource;
    }
}