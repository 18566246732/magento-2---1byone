<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/5/18
 * Time: 11:16 PM
 */

namespace TouchShop\Feedback\Model;


use Magento\Ui\DataProvider\AbstractDataProvider;
use TouchShop\Feedback\Model\ResourceModel\Complaint\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

class DataProvider extends AbstractDataProvider
{
    private $dataPersistor;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $pageCollectionFactory,
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
        /** @var $complaint \TouchShop\Complain\Model\Complaint */
        foreach ($items as $complaint) {
            $this->loadedData[$complaint->getId()] = $complaint->getData();
        }

        $data = $this->dataPersistor->get('complaint');
        if (!empty($data)) {
            $complaint = $this->collection->getNewEmptyItem();
            $complaint->setData($data);
            $this->loadedData[$complaint->getId()] = $complaint->getData();
            $this->dataPersistor->clear('complaint');
        }

        return $this->loadedData;
    }

}