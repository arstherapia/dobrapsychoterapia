<?php

namespace Frontend\OrderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MesOrderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('orderState', 'entity', [
                'class' => 'Frontend\OrderBundle\Entity\OrderState',
                'property' => 'name'
            ])
            ->add('shipingNumber')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Frontend\OrderBundle\Entity\MesOrder'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'frontend_orderbundle_mesorder';
    }
}
