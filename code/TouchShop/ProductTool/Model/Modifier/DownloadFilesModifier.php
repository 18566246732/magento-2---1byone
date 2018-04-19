<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/16/18
 * Time: 8:12 PM
 */

namespace TouchShop\ProductTool\Model\Modifier;


use Magento\Catalog\Model\Locator\LocatorInterface;
use Magento\Catalog\Ui\DataProvider\Product\Form\Modifier\AbstractModifier;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use TouchShop\ProductTool\Model\FileUploader;
use TouchShop\Support\Helper\DownloadFilesHelper;

class DownloadFilesModifier extends AbstractModifier
{
    private $locator;
    private $urlBuilder;
    private $storeManager;
    private $uploader;
    private $helper;


    /**
     * DownloadFilesModifier constructor.
     * @param LocatorInterface $locator
     * @param StoreManagerInterface $storeManager
     * @param FileUploader $uploader
     * @param DownloadFilesHelper $helper
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        LocatorInterface $locator,
        StoreManagerInterface $storeManager,
        FileUploader $uploader,
        DownloadFilesHelper $helper,
        UrlInterface $urlBuilder
    )
    {
        $this->locator = $locator;
        $this->urlBuilder = $urlBuilder;
        $this->uploader = $uploader;
        $this->storeManager = $storeManager;
        $this->helper = $helper;
    }

    public function modifyMeta(array $meta)
    {
        $config = $meta['support']['children']['container_download_files']['children']['download_files']['arguments']
        ['data']['config'];
        $config['componentType'] = 'field';
        $config['isMultipleFiles'] = true;
        $config['formElement'] = 'fileUploader';
        $config['dataType'] = 'string';
        $config['uploaderConfig'] = [
            'url' => $this->urlBuilder->addSessionParam()->getUrl('product_tool/upload/uploadFiles')];
        $meta['support']['children']['container_download_files']['children']['download_files']['arguments']
        ['data']['config'] = $config;

        return $meta;
    }

    /**
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        $product = $this->locator->getProduct();
        $data[$product->getId()]['product']['download_files'] = $this->helper->getDownloadFiles($product);
        return $data;
    }

}