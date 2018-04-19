<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 3/19/18
 * Time: 1:05 AM
 */

namespace TouchShop\Support\Controller\Index;


use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Block\Product\ImageBuilder;
use Magento\Catalog\Model\Product;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\Controller\ResultFactory;
use TouchShop\Support\Helper\DownloadFilesHelper;
use TouchShop\Support\Helper\FAQHelper;

class Index extends Action
{


    private $repository;
    private $connection;
    private $helper;
    private $imageBuilder;

    public function __construct(
        Context $context,
        ProductRepositoryInterface $repository,
        DownloadFilesHelper $helper,
        ImageBuilder $imageBuilder,
        ResourceConnection $connection
    )
    {

        parent::__construct($context);
        $this->repository = $repository;
        $this->helper = $helper;
        $this->imageBuilder = $imageBuilder;
        $this->connection = $connection->getConnection(ResourceConnection::DEFAULT_CONNECTION);
    }


    public function execute()
    {
        $data = (array)$this->getRequest()->getPost();
        if (empty($data)) {
            $this->_view->loadLayout();
            $this->_view->renderLayout();
            return null;
        } else {
            $result = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $result->setData($this->getProducts($data));
            return $result;
        }
    }


    /**
     * @param $data
     * @return null
     */
    private function getProducts($data)
    {
        if (isset($data['key']) && isset($data['page_num']) && isset($data['page_size'])) {

            $template = $this->getSqlTemplate($data['key']);
            $page_num = $data['page_num'] - 1;
            $page_size = $data['page_size'];
            $start = $page_num * $page_size;
            $end = $page_size;
            $result = [
                'total_count' => $this->connection->fetchOne($this->getCount($template))
            ];
            $products = [];
            $product_ids = $this->connection->fetchAll($this->getSearch($template, $start, $end));
            foreach ($product_ids as $product_id) {
                try {
                    $item = $this->repository->getById(intval($product_id['entity_id']));
                    /**@var $item Product */
                    $products[] = [
                        'product_name' => $item->getName(),
                        'image' => $this->getImage($item, 'category_page_list')->getImageUrl(),
                        'faq' => FAQHelper::getFAQ($item),
                        'download_files' => $this->helper->getDownloadFiles($item),
                        'url' => $item->getProductUrl()
                    ];
                } catch (\Exception $exception) {

                }
            }
            $result['products'] = $products;
            return $result;
        }
        return null;
    }

    public function getImage($product, $imageId)
    {
        return $this->imageBuilder->setProduct($product)
            ->setImageId($imageId)
            ->create();
    }


    private function getCount($template)
    {
        return 'select count(distinct e.entity_id)' . $template;
    }

    private function getSearch($template, $start, $end)
    {
        return 'select distinct e.entity_id' . $template . ' limit ' . $start . ',' . $end;
    }

    private function getSqlTemplate($key)
    {
        return ' from ' . $this->connection->getTableName('catalog_product_entity') . ' as e '
            . ' left join ' . $this->connection->getTableName('catalog_product_entity_varchar')
            . ' as v on e.entity_id=v.entity_id where'
            . '(select count(1) as num from catalog_product_super_link as s where s.product_id = e.entity_id) = 0 and ('
            . $this->getLikeStatement('name', $key) . ' or '
            . $this->getLikeStatement('amazon_asin', $key) . ' or '
            . '(e.sku like \'%' . $key . '%\'))';


    }

    private function getLikeStatement($attribute_code, $key)
    {
        $attribute_id = $this->getAttributeId($attribute_code);
        return '( v.attribute_id=' . $attribute_id . ' and v.value like \'%' . $key . '%\')';
    }

    private function getAttributeId($attribute)
    {
        $tableName = $this->connection->getTableName('eav_attribute');
        return $this->connection->fetchOne(
            'select e.attribute_id from '
            . $tableName
            . ' as e where e.attribute_code=\''
            . $attribute . '\' and e.entity_type_id=4;'
        );
    }


}