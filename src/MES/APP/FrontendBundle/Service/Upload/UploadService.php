<?php
namespace MES\APP\FrontendBundle\Service\Upload;

use MES\APP\FrontendBundle\Service\Exceptions\AdapterNotFoundException;
use MES\APP\FrontendBundle\Service\Upload\Exceptions\FileTypeNotFoundException;
use MES\APP\FrontendBundle\Service\Upload\Exceptions\UploadTypeNotFoundException;
use MES\APP\FrontendBundle\Service\Upload\Exceptions\ValidationException;

class UploadService
{
    /**
     * @var AdaptersCollection
     */
    protected $adaptersCollection;
    
    /**
     * @var FileTypesCollection
     */
    protected $fileTypesCollection;
    
    /**
     * @var UploadTypesCollection
     */
    protected $uploadTypesCollection;
    
    public function __construct(
        AdaptersCollection $adaptersCollection,
        FileTypesCollection $fileTypesCollection,
        UploadTypesCollection $uploadTypesCollection,
        UploadFileNamer $uploadFileNamer
    )
    {
        $this->adaptersCollection = $adaptersCollection;
        $this->fileTypesCollection = $fileTypesCollection;
        $this->uploadTypesCollection = $uploadTypesCollection;
        $this->uploadFileNamer = $uploadFileNamer;
    }
    
    public function handleUpload(UploadData $data) 
    {
        $uploadType = $this->uploadTypesCollection->getType($data->getType());
        
        if (!$uploadType) {
            throw new UploadTypeNotFoundException(sprintf("%s upload type not found", $data->getType()));
        }
        
        $fileType = $this->fileTypesCollection->getType($uploadType->getFileType());
        
        if (!$fileType) {
            throw new FileTypeNotFoundException(sprintf("%s file type not found", $uploadType->getFileType()));
        }
        
        try {
            $fileType->validate($data, $uploadType);
        } catch (ValidationException $exception) {
            $response = new UploadResponse();
            $response['files'] = [['error' => $exception->getMessage()]];
            return $response;
        }
        
        $adapter = $this->adaptersCollection->getAdapter($uploadType->getAdapter());
        
        if (!$adapter) {
            throw new AdapterNotFoundException(sprintf("%s adapter not found", $uploadType->getAdapter()));
        }
        
        $response = $adapter->storeUploadedFile($data, $uploadType);
        return $response;
    }
    
    public function uploadFromFile($filePath, $endpoint) 
    {
        $baseName = basename($filePath);
        
        $webUrl = $this->uploadFileNamer->getWebUrl($baseName, $endpoint);
        $key = $this->uploadFileNamer->getRelativePath($baseName);
        $path = $this->uploadFileNamer->getAbsolutePath($baseName, $endpoint);
        
        mkdir(dirname($path), 0777, true);
        copy($filePath, $path);
        
        $uploadData = new UploadData();
        $uploadData->setOriginalName($baseName);
        $uploadData->setPath($path);
        $uploadData->setKey($key);
        $uploadData->setType($endpoint);
        $uploadData->setWebUrl($webUrl);
        
        return $this->handleUpload($uploadData);
    }
}