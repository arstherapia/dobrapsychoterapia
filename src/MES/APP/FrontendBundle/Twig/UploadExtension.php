<?php

namespace MES\APP\FrontendBundle\Twig;

use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Twig_Extension;
use Twig_SimpleFilter;

/**
 * @author Bronisław Białek <bronislaw.bialek@gowork.pl>
 */
class UploadExtension extends Twig_Extension
{
    protected $imagine;
    
    public function __construct(CacheManager $imagine)
    {
        $this->imagine = $imagine;
    }
    
    public function getFilters()
    {
        return array(
            new Twig_SimpleFilter('thumbnail', array($this, 'uploadUrlFilter')),
        );
    }

    public function uploadUrlFilter($path, $filter)
    {
        return $this->imagine->getBrowserPath($path, $filter);
    }

    public function getName()
    {
        return 'upload_extension';
    }
}