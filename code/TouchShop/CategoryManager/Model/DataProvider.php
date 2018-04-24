<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/22/18
 * Time: 11:50 PM
 */

namespace TouchShop\CategoryManager\Model;


use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use TouchShop\CategoryManager\Model\ResourceModel\Manager\CategoryManagerCollectionFactory;

class DataProvider extends AbstractDataProvider
{
    private $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CategoryManagerCollectionFactory $pageCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $pageCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $complaint) {
            $this->loadedData[$complaint->getId()] = $complaint->getData();
        }

        $data = $this->dataPersistor->get('manager');
        if (!empty($data)) {
            $complaint = $this->collection->getNewEmptyItem();
            $complaint->setData($data);
            $this->loadedData[$complaint->getId()] = $complaint->getData();
            $this->dataPersistor->clear('manager');
        }

        return $this->loadedData;
    }

}