<?php
namespace MES\APP\FrontendBundle\Form\Type;

use Doctrine\Common\Persistence\ObjectManager;
use MES\APP\FrontendBundle\Form\DataTransformer\FileUploadModelTransformer;
use MES\APP\FrontendBundle\Form\DataTransformer\FileUploadViewTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class MovieType extends AbstractType
{
    /**
     * @var Session
     */
    protected $session;
    
    /**
     * @var ObjectManager
     */
    protected $om;
    
    public function __construct(ObjectManager $om, Session $session)
    {
        $this->session = $session;
        $this->om = $om;
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $session = $this->session;
        
        $builder->add(
            $builder
                ->create('path', 'text')
                ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($session) {
                    $data = $event->getData();
                    
                    if (!$data) {
                        return;
                    }
                    
                    $sessionFiles = $session->get('files', []);
                    $fileFound = false;
                    
                    foreach ($sessionFiles as $sessionFile) {
                        if (is_array($sessionFile) && $sessionFile['path'] === $data) {
                            $fileFound = true;
                        }
                    }
                    
                    if (!$fileFound) {
                        $event->getForm()->addError(new FormError('invalid_value'));
                        $event->setData(null);
                    }
                })
        );
                
        $om = $this->om;
        
        $builder->addEventListener('cleanup', function (FormEvent $event) use ($session, $om) {
            $data = $event->getData();

            if (!$data) {
                return;
            }

            $sessionFiles = $session->get('files', []);

            foreach ($sessionFiles as $key => $sessionFile) {
                if (is_array($sessionFile) && $sessionFile['path'] === $data) {
                    $id = $sessionFile['id'];
                    $file = $om->getRepository('MESAPPFrontendBundle:UploadFile')->find($id);
                    if ($file) {
                        $om->remove($file);
                        $om->flush();
                    }
                    unset($sessionFiles[$key]);
                }
            }
            
            $session->set('files', $sessionFiles);
        });
        
        $builder->addModelTransformer(new FileUploadModelTransformer);
        $builder->addViewTransformer(new FileUploadViewTransformer);
    }
    
    public function getParent()
    {
        return 'text';
    }

    public function getName()
    {
        return 'product_movie_upload';
    }
    
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['upload_endpoint'] = $options['upload_endpoint'];
    }
    
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'compound' => true,
                'upload_endpoint' => null,
            ))
            ->addAllowedTypes(array(
                'upload_endpoint' => 'string',
            ))
            ;
    }
}