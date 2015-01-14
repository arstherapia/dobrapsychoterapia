<?php
namespace MES\APP\FrontendBundle\Form\TypeExtension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;

class CleanupEventTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->addEventListener('cleanup', function (FormEvent $event) {
                foreach ($event->getForm()->all() as $child) {
                    $dispatcher = $child->getConfig()->getEventDispatcher();
                    
                    if ($dispatcher) {
                        $dispatcher->dispatch('cleanup', new FormEvent($child, $child->getData()));
                    }
                }
            })
            ;
    }

    public function getExtendedType()
    {
        return 'form';
    }
}