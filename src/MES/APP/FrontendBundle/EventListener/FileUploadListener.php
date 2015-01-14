<?php
namespace MES\APP\FrontendBundle\EventListener;

use MES\APP\FrontendBundle\Service\Upload\UploadData;
use MES\APP\FrontendBundle\Service\Upload\UploadFileNamer;
use MES\APP\FrontendBundle\Service\Upload\UploadResponse;
use MES\APP\FrontendBundle\Service\Upload\UploadService;
use Oneup\UploaderBundle\Event\PostPersistEvent;
use Symfony\Component\HttpFoundation\File\File;

class FileUploadListener
{
    protected $uploadService;
    protected $uploadFileNamer;
    
    public function __construct(UploadService $uploadService, UploadFileNamer $uploadFileNamer)
    {
        $this->uploadService = $uploadService;
        $this->uploadFileNamer = $uploadFileNamer;
    }
    
    public function onUpload(PostPersistEvent $event) 
    {
        $file = $event->getFile();
        /* @var $file File */
        
        $request = $event->getRequest();
        $requestFile = $request->files->all()['files'][0];
        
        // fix for FileNotFoundException propagated by parsing uploaded file again
        $_FILES = array();
        
        $uploadService = $this->uploadService;
        /* @var $uploadService UploadService */
        
        $webUrl = $this->uploadFileNamer->getWebUrl($file->getFilename(), $event->getType());
        $key = $this->uploadFileNamer->getRelativePath($file->getFilename());
        $path = $this->uploadFileNamer->getAbsolutePath($file->getFilename(), $event->getType());
        
        $uploadData = new UploadData();
        $uploadData->setOriginalName($requestFile->getClientOriginalName());
        $uploadData->setPath($path);
        $uploadData->setKey($key);
        $uploadData->setType($request->get('endpoint'));
        $uploadData->setWebUrl($webUrl);
        
        $uploadResponse = $uploadService->handleUpload($uploadData);
        
        $response = $event->getResponse();
        
        if ($uploadResponse instanceof UploadResponse) {
            foreach ($uploadResponse->getData() as $key => $val) {
                $response[$key] = $val;
            }
        }
    }
}