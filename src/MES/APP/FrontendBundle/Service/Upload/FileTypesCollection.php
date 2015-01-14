<?php
namespace MES\APP\FrontendBundle\Service\Upload;

class FileTypesCollection
{
    protected $types = [];
    
    public function addType(FileTypeInterface $type, $alias) 
    {
        $this->types[$alias] = $type;
        return $this;
    }
    
    /**
     * @param string $alias
     * @return FileTypeInterface
     */
    public function getType($alias) 
    {
        return $this->types[$alias];
    }
}