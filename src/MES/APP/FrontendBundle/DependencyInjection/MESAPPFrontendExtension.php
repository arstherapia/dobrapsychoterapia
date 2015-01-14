<?php

namespace MES\APP\FrontendBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class MESAPPFrontendExtension extends Extension implements PrependExtensionInterface
{
    /** @var string */
    protected $formTemplate = 'MESAPPFrontendBundle:Form:fields.html.twig';
    
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        
        $this->createUploadTypes($container, $config['types']);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
    
    private function createUploadTypes(ContainerBuilder $container, $typesConfig)
    {
        foreach ($typesConfig as $name => $typeConfig) {
            $id = 'upload.upload_types.'.$name;
            
            $type = new Definition("MES\\APP\\FrontendBundle\\Service\\Upload\\UploadType");
            $typeDefinition = $container->setDefinition($id, $type);
            
            $typeDefinition->addTag('upload.upload_type', ['alias' => $name]);
            
            $typeDefinition->addMethodCall('setAdapter', [$typeConfig['adapter']]);
            $typeDefinition->addMethodCall('setMapping', [$typeConfig['mapping']]);
            $typeDefinition->addMethodCall('setFileType', [$typeConfig['file_type']]);
            $typeDefinition->addMethodCall('setParameters', [$typeConfig['parameters']]);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function prepend(ContainerBuilder $container)
    {
        $bundles = $container->getParameter('kernel.bundles');

        $configs = $container->getExtensionConfig($this->getAlias());
        $config = $this->processConfiguration(new Configuration(), $configs);

        // Configure Twig if TwigBundle is activated and the option
        // "go_work_upload_bundle.auto_configure.twig" is set to TRUE (default value).
        if (true === isset($bundles['TwigBundle']) && true === $config['auto_configure']['twig']) {
            $this->configureTwigBundle($container);
        }
        
        if (true === isset($bundles['HearsayRequireJSBundle']) && true === $config['auto_configure']['hearsay_require_js']) {
            $this->configureHearsayRequireJSBundle($container);
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureTwigBundle(ContainerBuilder $container)
    {
        foreach (array_keys($container->getExtensions()) as $name) {
            switch ($name) {
                case 'twig':
                    $container->prependExtensionConfig(
                        $name,
                        array('form'  => array('resources' => array($this->formTemplate)))
                    );
                    break;
            }
        }
    }

    /**
     * @param ContainerBuilder $container The service container
     *
     * @return void
     */
    protected function configureHearsayRequireJSBundle(ContainerBuilder $container)
    {
        foreach (array_keys($container->getExtensions()) as $name) {
            switch ($name) {
                case 'hearsay_require_js':
                    $container->prependExtensionConfig(
                        $name,
                        array(
                            'paths'  => array(
//                                'jquery.ui.widget' => array(
//                                    'location' => $container->resolveServices('%kernel.root_dir%/../vendor/components/jqueryui/ui/minified/jquery.ui.widget.min'),
//                                ),
                                'fileupload' => array(
                                    'location' => $container->resolveServices('%kernel.root_dir%/../src/GoWork/Frontend/UploadBundle/Resources/public/js/fileupload'),
                                ),
                                'jqueryfileupload' => array(
                                    'location' => $container->resolveServices('%kernel.root_dir%/../src/GoWork/Frontend/UploadBundle/Resources/public/js/jqueryfileupload'),
                                ),
                            )
                        )
                    );
                    break;
            }
        }
    }
}
