<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 1:05 AM
 */

namespace TouchShop\Support\Controller\Index;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use TouchShop\Support\Helper\DownloadFilesHelper;
use TouchShop\Support\Helper\FAQHelper;

class Index extends Action
{
    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var FilterBuilder */
    private $filterBuilder;

    /** @var ProductRepositoryInterface */
    private $productRepository;

    /** @var SortOrderBuilder */
    private $sortOrderBuilder;

    /** @var FilterGroupBuilder */
    private $filterGroupBuilder;

    public function __construct(
        Context $context,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        ProductRepositoryInterface $productRepository,
        SortOrderBuilder $sortOrderBuilder,
        FilterGroupBuilder $filterGroupBuilder
    )
    {
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->productRepository = $productRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        parent::__construct($context);
    }


    public function execute()
    {
        $data = (array)$this->getRequest()->getPost();
        if (empty($data)) {
            $this->_view->loadLayout();
            $this->_view->renderLayout();
            return null;
        } else {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $result->setData($this->getProducts($data));
            return $result;
        }
    }


    private function getProducts($data)
    {
        if (isset($data['key']) && isset($data['page_num']) && isset($data['page_size'])) {
            $this->searchCriteriaBuilder->setFilterGroups($this->getFilterGroups($data['key']));
            $sortOrder = $this->sortOrderBuilder->setField('suggested')->setDirection(SortOrder::SORT_DESC)->create();
            $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
            $searchCriteria = $this->searchCriteriaBuilder->setCurrentPage($data['page_num'])->setPageSize($data['page_size'])->create();
            $searchResults = $this->productRepository->getList($searchCriteria);
            $result = [];
            $result['total_count'] = $searchResults->getTotalCount();
            $products = [];
            foreach ($searchResults->getItems() as $item) {
                /**@var $item Product */
                $products[] = [
                    'product_name' => $item->getName(),
                    'image' => '/pub/media/catalog/product' . $item->getImage(),
                    'faq' => FAQHelper::getFAQ($item),
                    'download_files' => DownloadFilesHelper::getDownloadFiles($item),
                    'url' => $item->getProductUrl()
                ];
            }
            $result['products'] = $products;
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