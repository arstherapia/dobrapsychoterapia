<?php
namespace MES\APP\FrontendBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

class UploadAdaptersCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('upload.adapters_collection')) {
            return;
        }

        $definition = $container->getDefinition(
            'upload.adapters_collection'
        );

        $taggedServices = $container->findTaggedServiceIds(
            'upload.adapter'
        );
        foreach ($taggedServices as $id => $attributes) {
            $definition->addMethodCall(
                'addAdapter',
                array(new Reference($id), $attributes[0]['alias'])
            );
        }
    }
}