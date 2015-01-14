<?php
namespace MES\APP\FrontendBundle\Service\Upload;

interface FileTypeInterface
{
    public function validate(UploadData $data, UploadType $uploadType);
}