<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/6/18
 * Time: 11:13 PM
 */

namespace TouchShop\CategoryManager\Block\Adminhtml\Manager\Edit;


use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Magento\Backend\Block\Widget\Context;

class BackButton implements ButtonProviderInterface
{
    private $context;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    )
    {
        $this->context = $context;
    }

    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Back'),
            'on_click' => sprintf("location.href = '%s';", $this->getBackUrl()),
            'class' => 'back',
            'sort_order' => 10
        ];
    }

    /**
     * Get URL for back (reset) button
     *
     * @return string
     */
    public function getBackUrl()
    {
        return $this->context->getUrlBuilder()->getUrl('category_manager/');
    }
}