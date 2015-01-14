<?php

namespace Frontend\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ContactType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('email')
                ->add('subject')
                ->add('message')
                ->add('copy', 'checkbox', ['label' => "Wyślij kopię do mnie", 'required' => false])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Frontend\FrontendBundle\Entity\Contact'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'frontend_frontendbundle_contact';
    }

}
