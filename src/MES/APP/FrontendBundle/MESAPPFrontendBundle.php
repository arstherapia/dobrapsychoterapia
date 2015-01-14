<?php

namespace MES\APP\FrontendBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MESAPPFrontendBundle extends Bundle
{
    public function build(\Symfony\Component\DependencyInjection\ContainerBuilder $container)
    {
        parent::build($container);
        
        $container->addCompilerPass(new DependencyInjection\UploadAdaptersCompilerPass());
        $container->addCompilerPass(new DependencyInjection\UploadFileTypesCompilerPass());
        $container->addCompilerPass(new DependencyInjection\UploadTypesCompilerPass());
    }
}
