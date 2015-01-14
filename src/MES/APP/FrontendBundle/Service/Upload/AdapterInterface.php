<?php
namespace MES\APP\FrontendBundle\Service\Upload;

interface AdapterInterface
{
    public function storeUploadedFile(UploadData $data, UploadType $uploadType);
}