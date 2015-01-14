<?php

namespace MES\APP\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class WidgetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('movies', 'entity', [
                    'class' => 'Frontend\FrontendBundle\Entity\Movies',
                    'property' => 'name',
                    'label' => 'Elements',
                    'max_length' => 6,
                    'multiple' => true
                ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Frontend\FrontendBundle\Entity\Widget'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'frontend_frontendbundle_widget';
    }
}
