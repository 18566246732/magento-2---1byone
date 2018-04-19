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
    private $context;

    public function __construct(
        FileUploader $uploader,
        Action\Context $context
    )
    {
        parent::__construct($context);
        $this->uploader = $uploader;
        $this->context = $context;
    }


    public function execute()
    {
        try {
            $post = (array)$this->getRequest()->getpost();
            $form_key = $post['form_key'];
            $fileId = $post['param_name'];
            $result = $this->uploader->saveFileToTmpDir($fileId, $form_key);
            $result['baseTempPath'] = $this->uploader->getFolderPath(
                $this->uploader->getBaseTempPath(),
                $form_key
            );
            $result['basePath'] = $this->uploader->getBasePath();
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}