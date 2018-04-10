<?php
/**
 * Created by PhpStorm.
 * User: jing
 * Date: 4/9/18
 * Time: 5:01 AM
 */

namespace TouchShop\ProductTool\Model;


use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Filesystem;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

class FileUploader
{
    private $database;
    private $uploaderFactory;
    private $storeManager;
    private $filesystem;
    private $logger;
    private $baseTempPath;
    private $basePath;
    private $mediaDirectory;

    /**
     * FileUploader constructor.
     * @param Database $database
     * @param UploaderFactory $uploaderFactory
     * @param StoreManagerInterface $storeManager
     * @param Filesystem $filesystem
     * @param LoggerInterface $logger
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    public function __construct(
        Database $database,
        UploaderFactory $uploaderFactory,
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        LoggerInterface $logger
    )
    {
        $this->database = $database;
        $this->uploaderFactory = $uploaderFactory;
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->mediaDirectory = $filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        $this->logger = $logger;
        $this->baseTempPath = 'product_tool/temp/download_files';
        $this->basePath = 'product_tool/download_files';
    }

    /**
     * @return string
     */
    public function getBaseTempPath(): string
    {
        return $this->baseTempPath;
    }

    /**
     * @param string $baseTempPath
     */
    public function setBaseTempPath(string $baseTempPath): void
    {
        $this->baseTempPath = $baseTempPath;
    }

    /**
     * @return string
     */
    public function getBasePath(): string
    {
        return $this->basePath;
    }

    /**
     * @param string $basePath
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    private function getFilePath($base, $name)
    {
        return rtrim($base, '/') . '/' . ltrim($name, '/');
    }

    /**
     * @param $file_name
     * @return mixed
     * @throws LocalizedException
     */
    public function moveFileFromTemp($file_name)
    {
        $baseTmpPath = $this->getBaseTempPath();
        $basePath = $this->getBasePath();
        $baseFilePath = $this->getFilePath($basePath, $file_name);
        $baseTmpFilePath = $this->getFilePath($baseTmpPath, $file_name);
        try {
            $this->database->copyFile(
                $baseTmpPath,
                $basePath
            );
            $this->mediaDirectory->renameFile(
                $baseTmpFilePath,
                $baseFilePath
            );
        } catch (\Exception $e) {
            throw new LocalizedException(
                __('Something went wrong while saving the file(s).')
            );
        }
        return $file_name;
    }

    /**
     * @param $fileId
     * @return array
     * @throws LocalizedException
     * @throws \Exception
     */
    public function saveFileToTmpDir($fileId)
    {
        $baseTmpPath = $this->getBaseTempPath();
        $uploader = $this->uploaderFactory->create(['fileId' => $fileId]);
//        $uploader->setAllowedExtensions($this->getAllowedExtensions());
        $uploader->setAllowRenameFiles(true);
        $result = $uploader->save($this->mediaDirectory->getAbsolutePath($baseTmpPath));
        if (!$result) {
            throw new LocalizedException(
                __('File can not be saved to the destination folder.')
            );
        }

        $result['tmp_name'] = str_replace('\\', '/', $result['tmp_name']);
        $result['path'] = str_replace('\\', '/', $result['path']);
        $result['url'] = $this->storeManager
                ->getStore()
                ->getBaseUrl(
                    UrlInterface::URL_TYPE_MEDIA
                ) . $this->getFilePath($baseTmpPath, $result['file']);
        $result['name'] = $result['file'];
        if (isset($result['file'])) {
            try {
                $relativePath = rtrim($baseTmpPath, '/') . '/' . ltrim($result['file'], '/');
                $this->database->saveFile($relativePath);
            } catch (\Exception $e) {
                $this->logger->critical($e);
                throw new LocalizedException(
                    __('Something went wrong while saving the file(s).')
                );
            }
        }
        return $result;
    }


}