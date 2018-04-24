<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 11:29 PM
 */

namespace TouchShop\CategoryManager\Ui\Component\Listing\Columns;


use Magento\Ui\Component\Listing\Columns\Column;

class Actions extends Column
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
                    'category_manager/manager/edit',
                    ['manager_id' => $item['manager_id']]
                ),
                'label' => __('Edit'),
                'hidden' => false,
            ];
        }

        return $dataSource;
    }
}