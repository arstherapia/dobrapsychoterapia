<?php

namespace MES\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MesCompanyType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', [
                'label' => "Nazwa firmy"
            ])
            ->add('nip', 'text', [
                'label' => "Nip"
            ])
            ->add('street', 'text', [
                'label' => "Ulica"
            ])
            ->add('buildingNumber', 'text', [
                'label' => "Nr. budynku"
            ])
            ->add('apartmentNumber', 'text', [
                'label' => "Nr. lokalu"
            ])
            ->add('postalCode', 'text', [
                'label' => "Kod pocztowy"
            ])
            ->add('city', 'text', [
                'label' => "Miasto"
            ])
            ->add('telephone', 'text', [
                'label' => "Nr. telefonu"
            ])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MES\UserBundle\Entity\MesCompany'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'mes_userbundle_mescompany';
    }
}
