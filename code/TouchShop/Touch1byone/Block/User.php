<?php
/**
 * Created by PhpStorm.
 * User: baozi
 * Date: 18-3-19
 * Time: 下午9:43
 */

namespace TouchShop\Touch1byone\Block;


use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;

class User extends Template
{
    /** @var SessionFactory */
    private $sessionFactory;


    public function __construct(
        SessionFactory $session,
        Template\Context $context,
        array $data = [])
    {
        $this->sessionFactory = $session;
        parent::__construct($context, $data);
    }


    public function getImgBaseUrl($imgName)
    {
        return $this->getBaseUrl() . 'pub/media/wysiwyg/' . $imgName;
    }

    public function hasLogin()
    {
        return $this->sessionFactory->create()->isLoggedIn();
    }

}
