<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/12/18
 * Time: 1:07 AM
 */

namespace TouchShop\Feedback\Ui\Component\Listing\Columns;


use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\Data\OptionSourceInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use TouchShop\ProductTool\Helper\CategoryHelper;

class CategorySelect extends Column implements OptionSourceInterface
{
    private $repository;

    public function __construct(
        CategoryRepository $repository,
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components = [],
        array $data = [])
    {
        parent::__construct($context, $uiComponentFactory, $components, $data);
        $this->repository = $repository;
    }


    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        return CategoryHelper::getCategories($this->repository);
    }
}