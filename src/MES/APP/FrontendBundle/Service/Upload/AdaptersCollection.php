<?php
namespace MES\APP\FrontendBundle\Service\Upload;

class AdaptersCollection
{
    protected $adapters = [];
    
    public function addAdapter(AdapterInterface $adapter, $alias) 
    {
        $this->adapters[$alias] = $adapter;
        return $this;
    }
    
    /**
     * @param string $alias
     * @return AdapterInterface
     */
    public function getAdapter($alias) 
    {
        return $this->adapters[$alias];
    }
}