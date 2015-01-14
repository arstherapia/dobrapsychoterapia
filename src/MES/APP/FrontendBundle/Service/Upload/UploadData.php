<?php

namespace MES\APP\FrontendBundle\Service\Upload;

class UploadData
{

    protected $path;
    protected $key;
    protected $originalName;
    protected $type;
    protected $webUrl;
    protected $extension;

    public function getPath()
    {
        return $this->path;
    }

    public function getKey()
    {
        return $this->key;
    }

    public function getOriginalName()
    {
        return $this->originalName;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setPath($path)
    {
        $this->path = $path;
        $this->setFileExtension(pathinfo($path, PATHINFO_EXTENSION));
        return $this;
    }

    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    public function setOriginalName($originalName)
    {
        $this->originalName = $originalName;
        return $this;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getWebUrl()
    {
        return $this->webUrl;
    }

    public function setWebUrl($webUrl)
    {
        $this->webUrl = $webUrl;
        return $this;
    }

    public function setFileExtension($fileExtension){
        $this->extension = $fileExtension;
        return $this;
    }
    
    public function getFileExtension()
    {
        return $this->extension;
    }

}
