<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/1/18
 * Time: 5:02 AM
 */

namespace TouchShop\ReviewTool\Controller\Index;


use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Registry;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollection;

class Index extends Action
{
    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var FilterBuilder */
    private $filterBuilder;

    /** @var ReviewAdvancedCollection */
    private $reviewAdvancedCollection;

    /** @var SortOrderBuilder */
    private $sortOrderBuilder;

    /** @var Registry */
    private $registry;


    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        ReviewAdvancedCollection $reviewAdvancedCollection,
        Registry $registry,
        SortOrderBuilder $sortOrderBuilder
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->reviewAdvancedCollection = $reviewAdvancedCollection;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->registry = $registry;
        parent::__construct($context);
    }


    public function execute()
    {
        $data = (array)$this->getRequest()->getPost();
        if (empty($data)) {
            return null;
        } else {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $result->setData($this->getReviews($data));
            return $result;
        }
    }


    private function getReviews($data)
    {
        $result = [];
        if (isset($data['page_num']) && isset($data['page_size'])) {
//            $this->searchCriteriaBuilder->addFilter($this->getFilter());
//            $sortOrder = $this->sortOrderBuilder->setField('sku')->setDirection(SortOrder::SORT_ASC)->create();
//            $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
//            $searchCriteria = $this->searchCriteriaBuilder->setCurrentPage($data['page_num'])->setPageSize($data['page_size'])->create();
//            $searchResults = $this->productRepository->getList($searchCriteria);
//            $result['total_count'] = $searchResults->getTotalCount();
//            $products = [];
//            foreach ($searchResults->getItems() as $item) {
//                /**@var $item Product */
//                $products[] = [
//                    'product_name' => $item->getName(),
//                    'image' => '/pub/media/catalog/product' . $item->getImage(),
//                    'faq' => FAQHelper::getFAQ($item),
//                    'download_files' => DownloadFilesHelper::getDownloadFiles($item),
//                    'url' => $item->getProductUrl()
//                ];
//            }
//            $result['products'] = $products;
            $product = $this->registry->registry('current_product');
            $id = $product->getId();
            $result['id'] = $id;
            return $result;
        }
        return null;
    }

    private function getFilterGroups($key)
    {
        $filter_fields = [
            'name',
            'sku',
            'amazon_asin'
        ];
        $key = '%' . $key . '%';
        foreach ($filter_fields as $field) {
            $filter = $this->filterBuilder->setField($field)->setValue($key)->setConditionType('like')->create();
            $this->filterGroupBuilder->addFilter($filter);
        }
        return [$this->filterGroupBuilder->create()];
    }

}