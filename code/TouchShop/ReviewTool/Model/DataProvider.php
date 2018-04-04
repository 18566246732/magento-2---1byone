<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/4/18
 * Time: 12:26 AM
 */

namespace TouchShop\ReviewTool\Model;


use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollection;

class DataProvider extends AbstractDataProvider
{
    private $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        ReviewAdvancedCollection $collection,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collection;
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $review) {
            $this->loadedData[$review->getId()] = $review->getData();
        }

        $data = $this->dataPersistor->get('review');
        if (!empty($data)) {
            $review = $this->collection->getNewEmptyItem();
            $review->setData($data);
            $this->loadedData[$review->getId()] = $review->getData();
            $this->dataPersistor->clear('review');
        }
        return $this->loadedData;
    }
}