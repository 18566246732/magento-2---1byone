<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 6:22 PM
 */

namespace TouchShop\Support\Block;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;

class SupportBlock extends Template
{
    /** @var Registry */
    private $registry;

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

        Template\Context $context,
        Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        ProductRepositoryInterface $productRepository,
        SortOrderBuilder $sortOrderBuilder,
        FilterGroupBuilder $filterGroupBuilder,
        array $data = []
    )
    {
        $this->registry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->productRepository = $productRepository;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->filterGroupBuilder = $filterGroupBuilder;
        parent::__construct($context, $data);
    }


    public function getProducts()
    {
        $data = $this->registry->registry('support_post');
        if (isset($data['key']) && isset($data['page_num']) && isset($data['page_size'])) {
            $this->searchCriteriaBuilder->setFilterGroups($this->getFilterGroups($data['key']));
            $sortOrder = $this->sortOrderBuilder->setField('price')->setDirection(SortOrder::SORT_ASC)->create();
            $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
            $searchCriteria = $this->searchCriteriaBuilder->setCurrentPage($data['page_num'])->setPageSize($data['page_size'])->create();
            $searchResults = $this->productRepository->getList($searchCriteria);
            $items = $searchResults->getItems();
            return $items;
        }
        return [];
    }

    public function getFilterGroups($key)
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