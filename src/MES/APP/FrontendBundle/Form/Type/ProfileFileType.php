<?php
namespace MES\APP\FrontendBundle\Form\Type;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProfileFileType extends EntityType
{
    public function getParent()
    {
        return 'entity';
    }

    public function getName()
    {
        return 'profile_file';
    }
    
    public function buildView(FormView $view,
            FormInterface $form, array $options)
    {
        $view->vars['upload_endpoint'] = $options['upload_endpoint'];
        $view->vars['files_choice'] = $options['files_choice'];
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'upload_endpoint' => null,
                'class' => 'GoWorkCommonUserBundle:UserProfileFile',
                'property' => 'id',
                'files_choice' => array(),
            ))
            ->addAllowedTypes(array(
                'upload_endpoint' => 'string',
                'files_choice' => 'array',
            ))
            ;
    }
}