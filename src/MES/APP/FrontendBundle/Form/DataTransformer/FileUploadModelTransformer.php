<?php
namespace MES\APP\FrontendBundle\Form\DataTransformer;

use MES\APP\FrontendBundle\Entity\UploadFile;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author Bronisław Białek <bronislaw.bialek@gowork.pl>
 */
class FileUploadModelTransformer implements DataTransformerInterface
{
    /**
     * @return string
     */
    public function transform($path)
    {
        return array(
            'original_path' => $path,
        );
    }

    public function reverseTransform($fileUploadData)
    {
        $newPath = $fileUploadData['path'];
        $originalPath = $fileUploadData['original_path'];
        
        if ($newPath) {
            return $newPath;
        }
        
        return $originalPath;
    }
}