<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/23/18
 * Time: 1:24 AM
 */

namespace TouchShop\CategoryManager\Helper;


use Magento\Backend\Model\UrlInterface;
use Magento\Catalog\Model\CategoryRepository;
use Magento\Framework\App\Area;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\CategoryManager\Model\ResourceModel\Manager\CategoryManagerCollectionFactory;

abstract class AbstractEmailContentProvider
{
    private $transportBuilder;
    private $storeManager;
    private $urlBuilder;
    private $collection;
    private $categoryRepository;

    public function __construct(
        TransportBuilder $transportBuilder,
        UrlInterface $urlBuilder,
        CategoryManagerCollectionFactory $collection,
        StoreManagerInterface $storeManager,
        CategoryRepository $categoryRepository
    )
    {
        $this->transportBuilder = $transportBuilder;
        $this->storeManager = $storeManager;
        $this->urlBuilder = $urlBuilder;
        $this->collection = $collection;
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * @param $object
     * @throws \Magento\Framework\Exception\MailException
     */
    public function sendEmail($object)
    {
        $emails = ['ushelp@1byone.com'];
        try {
            $categoryId = $object->getCategoryId();
            if ($categoryId) {
                $collection = $this->collection->create();
                $collection->addFieldToFilter('category_id', $categoryId);
                if (count($collection) > 0) {
                    foreach ($collection as $manager) {
                        if ($manager->getEmail()) {
                            $emails = explode(',', $manager->getEmail());
                            break;
                        }
                    }
                }
            } else {
                $categoryNames = $object->getCategories();
                foreach (explode(',', $categoryNames) as $name) {
                    $collection = $this->collection->create();
                    $collection->addFieldToFilter('name', $name);
                    if (count($collection) > 0) {
                        foreach ($collection as $manager) {
                            if ($manager->getEmail()) {
                                $emails = explode(',', $manager->getEmail());
                                break;
                            }
                        }
                    }
                }
            }

        } catch (\Exception $e) {

        }


        $transport = $this->transportBuilder
            ->setTemplateIdentifier('notification_template')
            ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => $this->storeManager->getStore()->getId()])
            ->setTemplateVars([
                'content' => $this->getContent($object),
                'admin' => $this->urlBuilder->getUrl($this->getUrlPath()),
                'title' => $this->getTitle($object)
            ])
            ->setFrom([
                'name' => '1byone',
                'email' => 'ushelp@1byone.com',
            ])
            ->addTo($emails)
            ->getTransport();
        $transport->sendMessage();
    }

    protected function get_category_name($category_id)
    {
        try {
            return $this->categoryRepository->get($category_id)->getName();
        } catch (NoSuchEntityException $e) {
            return 'Unknown';
        }

    }

    abstract public function getContent($object);

    abstract public function getUrlPath();

    abstract public function getTitle($object);


}