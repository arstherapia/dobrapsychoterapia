<?php

namespace MES\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LoginForm extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('__username')
                ->add('__password', 'password')
                ->add('submit', 'submit', [
                    'attr' => [
                        'class' => 'btn-default'
                    ]
                ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'MES\UserBundle\Entity\MesUser'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'mes_userbundle_mesuser';
    }

}
