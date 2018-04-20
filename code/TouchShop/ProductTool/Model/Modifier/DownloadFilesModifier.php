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

        $meta['support']['children']['container_product_faq']['children']['product_faq']['arguments']
        ['data']['config']['notice'] = "问题以Q:开头占一行，答案以A:开头可以多行，问答与问答之间空一行。冒号为英文冒号,
        例如:Q:Is this an outdoor antenna?<换行>
        A: No, it is a indoor antenna. <换行>You can put it higher on wall; lay flat on table; place it high on window.
        <换行><换行>Q: What is this?<换行>
        A: Antenna";

        $meta['sort-optimization']['children']['container_discount']['children']['discount']['arguments']
        ['data']['config']['notice'] = '从00到99，确保写两位，用户选择按discount排序时，这里的值越大产品越靠前';

        $meta['sort-optimization']['children']['container_suggested']['children']['suggested']['arguments']
        ['data']['config']['notice'] = '从000000到999999，确保写六位。用户选择按suggested排序时，这里的值越大产品越靠前。';

        $meta['sort-optimization']['children']['container_mark']['children']['mark']['arguments']
        ['data']['config']['notice'] = '显示在图片右上角的标签。例如20% OFF。建议不要超过7个英文字符，建议设置后进行到产品页查看
        效果，根据实际效果决定标签文本内容';

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