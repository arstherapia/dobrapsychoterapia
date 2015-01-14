<?php
namespace MES\APP\FrontendBundle\Form\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

/**
 * @author Bronisław Białek <bronislaw.bialek@gowork.pl>
 */
class FileUploadViewTransformer implements DataTransformerInterface
{
    /**
     * @return string
     */
    public function transform($data)
    {
        if (isset($data['file'])) {
            $data['path'] = $data['file']->getPath();
        }
        if (isset($data['original_path'])) {
            $data['path'] = $data['original_path'];
        }
        return $data;
    }

    /**
     * @throws TransformationFailedException if object (issue) is not found.
     */
    public function reverseTransform($data)
    {
        return $data;
    }
}