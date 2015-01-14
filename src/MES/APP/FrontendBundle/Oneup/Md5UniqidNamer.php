<?php

namespace MES\APP\FrontendBundle\Oneup;

use MES\APP\FrontendBundle\Service\Upload\UploadFileNamer;
use Oneup\UploaderBundle\Uploader\File\FileInterface;
use Oneup\UploaderBundle\Uploader\Naming\NamerInterface;

class Md5UniqidNamer implements NamerInterface
{
    protected $uploadFileNamer;
    
    public function __construct(UploadFileNamer $uploadFileNamer)
    {
        $this->uploadFileNamer = $uploadFileNamer;
    }
    
    public function name(FileInterface $file)
    {
        $uniq = md5(uniqid());
        $path = $this->uploadFileNamer->getRelativePath($uniq);
        
        return sprintf('%s.%s', $path, $file->getExtension());
    }
}
