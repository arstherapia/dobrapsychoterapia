<?php

namespace MES\SecurityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MesUserType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email')
                ->add('username', 'text', [
                    'label' => 'Nazwa użytkownika'
                ])
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'Hasła muszą się zgadzać',
                    'options' => array('attr' => array('class' => 'password-field')),
                    'required' => true,
                    'first_options' => array('label' => 'Hasło'),
                    'second_options' => array('label' => 'Powtórz hasło'),
                ))
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
