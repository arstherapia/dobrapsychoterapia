<?php

namespace Frontend\OrderBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class OrderForm extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('shiping', new \MES\UserBundle\Form\MesProfileType(), [
                    'label' => false
                ])
                ->add('company', new \MES\UserBundle\Form\MesCompanyType(), [
                    'label' => false,
                    'required' => false
                ])
                ->add('email', 'email', ['label' => 'Email'])
                ->add('submit', 'submit',[
                    'label' => 'Zamawiam',
                    'attr' => [
                        'class' => 'btn-default'
                    ],
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
        return null;
    }

}
