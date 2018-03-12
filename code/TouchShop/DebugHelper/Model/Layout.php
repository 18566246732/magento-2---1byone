<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 2/6/18
 * Time: 10:02 PM
 */

namespace TouchShop\DebugHelper\Model;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;

class Layout implements ObserverInterface
{

    /**
     * @param Observer $observer
     * @return self
     */
    public function execute(Observer $observer)
    {

        $xml = $observer->getEvent()->getLayout()->getXmlString();
        $urlInterface = \Magento\Framework\App\ObjectManager::getInstance()->get('Magento\Framework\UrlInterface');
        $url = $urlInterface->getCurrentUrl();
        $url = str_replace('/', '_', $url);
        $result = file_put_contents('backup/layouts/' . $url . '.xml', $xml);
        return $this;
    }
}
