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

class DownloadFilesModifier extends AbstractModifier
{
    private $locator;
    private $urlBuilder;


    /**
     * DownloadFilesModifier constructor.
     * @param LocatorInterface $locator
     * @param UrlInterface $urlBuilder
     */
    public function __construct(
        LocatorInterface $locator,
        UrlInterface $urlBuilder
    )
    {
        $this->locator = $locator;
        $this->urlBuilder = $urlBuilder;
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
        return $data;
    }
}