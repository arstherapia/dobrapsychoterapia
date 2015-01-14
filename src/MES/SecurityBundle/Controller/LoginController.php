<?php

namespace MES\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class LoginController extends Controller {

    /**
     * @Route("/login", name="mes_login")
     * @Template()
     */
    public function indexAction() {
        $form = $this->get('form.factory')->createNamed(
                '', new \MES\SecurityBundle\Form\LoginForm()
        );
        return ['form' => $form->createView()];
    }

    /**
     * @Route("/login_check", name="mes_login_check")
     * @Method({"POST"})
     */
    public function loginCheck() {
        
    }
    
    /**
     * @Route("/logout", name="mes_logout")
     * @Method({"GET"})
     */
    public function logoutAction(){
        $this->container->get('security.context')->setToken(NULL);
        return $this->redirect($this->generateUrl('mes_login'));
    }

}
