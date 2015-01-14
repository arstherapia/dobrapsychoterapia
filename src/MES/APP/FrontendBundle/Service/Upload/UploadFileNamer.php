<?php
namespace MES\APP\FrontendBundle\Service\Upload;

class UploadFileNamer
{
    protected $baseDirectory;
    
    public function __construct($baseDirectory)
    {
        $this->baseDirectory = $baseDirectory;
    }
    
    public function getAbsolutePath($key, $type)
    {
        return $this->baseDirectory . $type . '/' . $this->getRelativePath($key, $type);
    }
    
    public function getRelativePath($key)
    {
        $url = '';
        
        for ($i = 1, $c = min(3, strlen($key)); $i < $c; $i ++) {
            $url .= substr($key, 0, $i) . '/';
        }
        
        return sprintf('%s', $url . $key);
    }
    
    public function getWebUrl($key, $type)
    {
        return '/uploads/' . $type . '/' . $this->getRelativePath($key, $type);
    }
}