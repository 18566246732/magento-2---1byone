<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/1/18
 * Time: 9:08 PM
 */

namespace TouchShop\ReviewTool\Block\Product\View;


use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use function Symfony\Component\DependencyInjection\Loader\Configurator\iterator;
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

    public function __construct(
        Registry $registry,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        FilterBuilder $filterBuilder,
        ReviewAdvancedCollectionFactory $reviewAdvancedCollectionFactory,
        SortOrderBuilder $sortOrderBuilder,
        Context $context,
        array $data
    )
    {
        $this->registry = $registry;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->reviewAdvancedCollectionFactory = $reviewAdvancedCollectionFactory;
        $this->sortOrderBuilder = $sortOrderBuilder;
        parent::__construct($context, $data);
    }


    private function getReviewData()
    {
        $data = $this->registry->registry('postData');
        if (isset($data['id']) && isset($data['page_num']) && isset($data['page_size'])) {
            $result = [];
            $collection = $this->reviewAdvancedCollectionFactory->create();
            $collection->addFieldToFilter('product_id', ['eq' => $data['id']]);
            $result['total'] = $collection->getSize();
            $collection->addOrder('top_index', 'ASC');
            $collection->setCurPage($data['page_num']);
            $collection->setPageSize($data['page_size']);

            foreach ($collection as $item) {
                $review = [];
                $review_id = $item->getReviewId();

            }

            return $result;
        }
    }
}