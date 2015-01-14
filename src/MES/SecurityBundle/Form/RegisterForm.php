<?php

namespace MES\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterForm extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('user', new MesUserType(), [
                    'label' => false
                ])
                ->add('profile', new \MES\UserBundle\Form\MesProfileType(), [
                    'label' => false
                ])
                ->add('submit','submit', [
                    'attr' => [
                        'class' => 'btn-default'
                    ],
                    'label' => 'Rejestruj'
                ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => null
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'mesuser';
    }

}
