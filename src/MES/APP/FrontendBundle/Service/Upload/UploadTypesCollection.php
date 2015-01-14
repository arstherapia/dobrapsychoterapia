<?php
namespace MES\APP\FrontendBundle\Service\Upload;

class UploadTypesCollection
{
    protected $types = [];
    
    public function addType(UploadType $type, $alias) 
    {
        $this->types[$alias] = $type;
        return $this;
    }
    
    /**
     * @param string $name
     * @return UploadType
     */
    public function getType($name) 
    {
        return isset($this->types[$name]) ? $this->types[$name] : null;
    }
}