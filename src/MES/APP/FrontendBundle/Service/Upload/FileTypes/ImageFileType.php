<?php
namespace MES\APP\FrontendBundle\Service\Upload\FileTypes;

use MES\APP\FrontendBundle\Service\Upload\Exceptions\ValidationException;
use MES\APP\FrontendBundle\Service\Upload\FileTypeInterface;
use MES\APP\FrontendBundle\Service\Upload\UploadData;
use MES\APP\FrontendBundle\Service\Upload\UploadType;

class ImageFileType implements FileTypeInterface
{
    public function validate(UploadData $data, UploadType $uploadType)
    {
        $filename = $data->getPath();
        $imageData = getimagesize($filename);
        
        if (!$imageData) {
            throw new ValidationException('error.image');
        }
        
        $minWidth = $uploadType->getParameter('min_width');
        if ($minWidth && $imageData[0] < $minWidth) {
            throw new ValidationException('error.image_width_min');
        }
        $maxWidth = $uploadType->getParameter('max_width');
        if ($maxWidth && $imageData[0] > $maxWidth) {
            throw new ValidationException('error.image_width_max');
        }
        $minHeight = $uploadType->getParameter('min_height');
        if ($minHeight && $imageData[1] < $minHeight) {
            throw new ValidationException('error.image_height_min');
        }
        $maxHeight = $uploadType->getParameter('max_height');
        if ($maxHeight && $imageData[1] > $maxHeight) {
            throw new ValidationException('error.image_height_max');
        }
        
        return false;
    }
}