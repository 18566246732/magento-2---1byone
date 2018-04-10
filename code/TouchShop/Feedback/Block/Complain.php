<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/26/18
 * Time: 5:09 PM
 */

namespace TouchShop\Feedback\Block;

use Magento\Customer\Model\ResourceModel\CustomerRepository;
use Magento\Customer\Model\Session;
use Magento\Framework\View\Element\Template;
use TouchShop\Basic\Helper\CustomerHelper;

class Complain extends Template
{
    private $session;
    private $repository;

    public function __construct(
        Session $session,
        CustomerRepository $repository,
        Template\Context $context,
        array $data = [])
    {

        parent::__construct($context, $data);
        $this->session = $session;
        $this->repository = $repository;
    }


    /**
     * Retrieve form action
     *
     * @return string
     */
    public function getFormAction()
    {
        return $this->getBaseUrl() . '/feedback';
    }

    public function getLoginInfo()
    {
        return CustomerHelper::getLoginInfo($this->session, $this->repository);
    }
}