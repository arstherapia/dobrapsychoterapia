<?php

namespace MES\SecurityBundle\Controller;

use MES\SecurityBundle\Entity\MesUserRoles;
use MES\SecurityBundle\Form\RegisterForm;
use MES\SecurityBundle\Security\Manager\MESUserManager;
use MES\SecurityBundle\Security\MesUserInterface;
use MES\SecurityBundle\Security\Provider\MESUserProvider;
use MES\UserBundle\Entity\MesProfile;
use MES\UserBundle\Entity\MesUser;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends Controller
{

    /**
     * @Route("/rejestracja", name="mes_register")
     * @Route("/rejestracja", name="mes_register_post")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $form = $this->get('form.factory')->createNamed(
            '', new RegisterForm()
        );
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $this->handleRegister($form->getData());
                return [];
            }
        }
        return ['form' => $form->createView()];
    }

    protected function handleRegister($data)
    {
        /* @var $user MesUser */
        $user         = $data['user'];
        /* @var $profile MesProfile */
        $profile      = $data['profile'];
        /* @var $userManager MESUserManager */
        $userManager  = $this->get('mes_user_manager');
        /* @var $userProvider MESUserProvider */
        $userProvider = $this->get('mes_user_provider');

        $userManager->registerNewUser($user->getUsername(), $user->getEmail(),
            $user->getPassword(), $profile->getName(), $profile->getSurname());
        $persistedUser = $userProvider->findUserBy(['email' => $user->getEmail()]);
        $profile->setMesUser($persistedUser);
        $em            = $this->getDoctrine()->getManager();
        $em->persist($profile);
        $em->flush();
        /* @var $mailer \Frontend\OrderBundle\Services\Mailer */
        $mailer        = $this->get('mail_manager');
        $mailer->sendUserCreateEmail($persistedUser);
        $this->promoteUserToUser($persistedUser);
        return;
    }

    /**
     * 
     * @return MesUserRoles
     */
    protected function getUserRole()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('\MES\SecurityBundle\Entity\MesUserRoles')->findOneBy(['id' => MesUserRoles::ROLE_USER]);
    }

    protected function promoteUserToUser(MesUserInterface $user)
    {
        /* @var $userProvider MESUserProvider */
        $userProvider = $this->get('mes_user_provider');
        $user->addMesUserRole($this->getUserRole());
        $userProvider->updateUser($user);
        return;
    }
}