<?php
namespace MES\APP\FrontendBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class UploadFileTypesCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('upload.file_types_collection')) {
            return;
        }

        $definition = $container->getDefinition(
            'upload.file_types_collection'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'upload.file_type'
        );
        
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addType',
                array(new Reference($id), $attributes[0]['alias'])
            );
        }
    }
}