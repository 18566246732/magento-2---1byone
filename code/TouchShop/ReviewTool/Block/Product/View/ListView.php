<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/1/18
 * Time: 9:08 PM
 */

namespace TouchShop\ReviewTool\Block\Product\View;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product;
use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use function Symfony\Component\DependencyInjection\Loader\Configurator\iterator;
use TouchShop\ProductTool\Helper\ProductHelper;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollection;
use TouchShop\ReviewTool\Model\ResourceModel\ReviewAdvanced\ReviewAdvancedCollectionFactory;

class ListView extends Template
{
    /** @var Registry */
    private $registry;

    /** @var SearchCriteriaBuilder */
    private $searchCriteriaBuilder;

    /** @var FilterBuilder */
    private $filterBuilder;

    /** @var ReviewAdvancedCollectionFactory */
    private $reviewAdvancedCollectionFactory;

    /** @var SortOrderBuilder */
    private $sortOrderBuilder;

    /** @var ProductRepositoryInterface */
    private $productRepository;


    public function __construct(
        Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        ReviewAdvancedCollectionFactory $reviewAdvancedCollectionFactory,
        SortOrderBuilder $sortOrderBuilder,
        Context $context,
        ProductRepositoryInterface $productRepository,
        array $data
    )
    {
        $this->registry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->reviewAdvancedCollectionFactory = $reviewAdvancedCollectionFactory;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->productRepository = $productRepository;
        parent::__construct($context, $data);
    }


    public function getReviewData()
    {
        $data = $this->registry->registry('postData');
        if (isset($data['id']) && isset($data['page_num']) && isset($data['page_size'])) {
            $result = [];
            $collection = $this->reviewAdvancedCollectionFactory->create();
            try {
                $this->addFilters($collection, $data['id']);
            } catch (NoSuchEntityException $e) {
                return [];
            }
            $result['total'] = $collection->getSize();
            $result['page_num'] = $data['page_num'];
            $collection->addOrder('top_index', 'ASC');
            $collection->addOrder('date', 'DESC');
            $collection->setCurPage($data['page_num']);
            $collection->setPageSize($data['page_size']);

            foreach ($collection as $item) {
                $review = [];
                $review['star'] = $item->getStar();
                $review['title'] = $item->getTitle();
                $review['author'] = $item->getAuthor();
                $review['comment'] = $item->getComment();
                $review['date'] = $item->getDate();
                $review['videos_url'] = explode(",", $item->getVideoUrls());
                $review['images_url'] = explode(",", $item->getImageUrls());
            }

            return $result;
        }
        return null;
    }

    /**
     * @param $collection ReviewAdvancedCollection
     * @param $product_id
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function addFilters($collection, $product_id)
    {
        /**@var $product Product */
        $product = $this->productRepository->getById($product_id);
        $field = 'product_id';
        $fields = [];
        $conditions = [];
        if ($product) {
            if (ProductHelper::isConfigurable($product)) {
                $fields[] = $field;
                $conditions[] = ['eq' => $product_id];
                foreach (ProductHelper::getChildren($product) as $child) {
                    $fields[] = $field;
                    $conditions[] = ['eq' => $child->getId()];
                }
            } elseif (ProductHelper::isSimple($product)) {
                $fields = $field;
                $conditions = ['eq' => $product_id];
            }
        }

        $collection->addFieldToFilter($fields, $conditions);
    }
}