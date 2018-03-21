<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 6:22 PM
 */

namespace TouchShop\Support\Block;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\FilterGroupBuilder;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use TouchShop\Support\Helper\DownloadFilesHelper;
use TouchShop\Support\Helper\FAQHelper;

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
            $sortOrder = $this->sortOrderBuilder->setField('sku')->setDirection(SortOrder::SORT_ASC)->create();
            $this->searchCriteriaBuilder->setSortOrders([$sortOrder]);
            $searchCriteria = $this->searchCriteriaBuilder->setCurrentPage($data['page_num'])->setPageSize($data['page_size'])->create();
            $searchResults = $this->productRepository->getList($searchCriteria);
            $result = [];
            $result['total_count'] = $searchResults->getTotalCount();
            $products = [];
            foreach ($searchResults->getItems() as $item) {
                /**@var $item Product */
                $products[] = [
                    'image' => 'pub/media/catalog/product' . $item->getImage(),
                    'faq' => FAQHelper::getFAQ($item),
                    'download_files' => DownloadFilesHelper::getDownloadFiles($item)
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