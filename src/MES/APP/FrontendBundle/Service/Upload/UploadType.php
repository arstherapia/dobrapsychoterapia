<?php

namespace MES\APP\FrontendBundle\Service\Upload;

class UploadType
{

    protected $name;
    protected $parameters = [];
    protected $mapping;
    protected $fileType;
    protected $adapter;

    public function getName()
    {
        return $this->name;
    }

    public function getParameters()
    {
        return $this->parameters;
    }

    public function getParameter($name, $default = null)
    {
        foreach ($this->parameters as $param) {
            if ($param['name'] === $name) {
                return $param['value'];
            }
        }

        return $default;
    }

    public function getMapping()
    {
        return $this->mapping;
    }

    public function getFileType()
    {
        return $this->fileType;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function setMapping($mapping)
    {
        $this->mapping = $mapping;
        return $this;
    }

    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
        return $this;
    }

    public function getAdapter()
    {
        return $this->adapter;
    }

    public function setAdapter($adapter)
    {
        $this->adapter = $adapter;
        return $this;
    }

}
