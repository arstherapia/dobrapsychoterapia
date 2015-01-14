<?php
namespace MES\APP\FrontendBundle\Service\Upload\FileTypes;

use MES\APP\FrontendBundle\Service\Upload\Exceptions\ValidationException;
use MES\APP\FrontendBundle\Service\Upload\FileTypeInterface;
use MES\APP\FrontendBundle\Service\Upload\UploadData;
use MES\APP\FrontendBundle\Service\Upload\UploadType;

class MovieFileType implements FileTypeInterface
{
    public function validate(UploadData $data, UploadType $uploadType)
    {
        $filename = $data->getPath();
        
        if (!$filename) {
            throw new ValidationException('error.movie');
        }
        
        return false;
    }
}