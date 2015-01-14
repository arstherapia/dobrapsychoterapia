<?php
namespace MES\APP\FrontendBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class UploadTypesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('upload.upload_types_collection')) {
            return;
        }

        $definition = $container->getDefinition(
            'upload.upload_types_collection'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'upload.upload_type'
        );
        
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addType',
                array(new Reference($id), $attributes[0]['alias'])
            );
        }
    }
}