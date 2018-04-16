<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/13/18
 * Time: 4:20 AM
 */

namespace TouchShop\Refund\Model;


use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use TouchShop\Refund\Model\ResourceModel\Refund\RefundCollectionFactory;

class DataProvider extends AbstractDataProvider
{
    private $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        RefundCollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $refund) {
            $this->loadedData[$refund->getId()] = $refund->getData();
        }

        $data = $this->dataPersistor->get('refund');
        if (!empty($data)) {
            $refund = $this->collection->getNewEmptyItem();
            $refund->setData($data);
            $this->loadedData[$refund->getId()] = $refund->getData();
            $this->dataPersistor->clear('refund');
        }

        return $this->loadedData;
    }

}