<?php

namespace MES\APP\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MoviesType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('name')
                ->add('cover', 'image_upload', array(
                    'upload_endpoint' => 'product_image'
                ))
                ->add('video', 'image_upload', array(
                    'upload_endpoint' => 'product_movie'
                ))
                ->add('description')
                ->add('descriptionShort')
                ->add('proffesionalPrice')
                ->add('individualPrice')
                ->add('minutes')
                ->add('numberOfDiscs')
                ->add('title')
                ->add('seoDescribtion')
                ->add('seoKeywords')
                ->add('similar', 'entity', [
                    'class' => 'Frontend\FrontendBundle\Entity\Movies',
                    'property' => 'name',
                    'label' => 'Similar',
                    'max_length' => 3,
                    'multiple' => true
                ])
                ->add('movieStatus', 'entity', [
                    'class' => 'Frontend\FrontendBundle\Entity\MovieStatus',
                    'property' => 'name',
                    'multiple' => false
                ])
                ->add('catagory', 'entity', [
                    'class' => 'Frontend\FrontendBundle\Entity\Catagory',
                    'property' => 'name',
                    'multiple' => true
                ])
                ->add('languages', 'entity', [
                    'class' => 'Frontend\FrontendBundle\Entity\Languages',
                    'property' => 'name',
                    'label' => 'Subtitles',
                    'multiple' => true
                ])
                ->add('problems', 'entity', [
                    'class' => 'Frontend\FrontendBundle\Entity\Problems',
                    'property' => 'name',
                    'multiple' => true
                ])
                ->add('therapist', 'entity', [
                    'class' => 'Frontend\FrontendBundle\Entity\Therapist',
                    'property' => 'name',
                    'multiple' => true
                ])
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Frontend\FrontendBundle\Entity\Movies'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'frontend_frontendbundle_movies';
    }

}
