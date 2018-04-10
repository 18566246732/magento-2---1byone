<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/9/18
 * Time: 4:59 AM
 */

namespace TouchShop\ProductTool\Controller\Adminhtml\Upload;


use Magento\Backend\App\Action;
use Magento\Framework\Controller\ResultFactory;
use TouchShop\ProductTool\Model\FileUploader;

class UploadFiles extends Action
{
    private $uploader;

    public function __construct(
        FileUploader $uploader,
        Action\Context $context
    )
    {
        parent::__construct($context);
        $this->uploader = $uploader;
    }


    public function execute()
    {
        try {
            $result = $this->uploader->saveFileToTmpDir('icon');
            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}