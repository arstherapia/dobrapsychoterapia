<?php

namespace MES\APP\FrontendBundle\Controller;

use MES\UserBundle\Entity\MesCompany;
use MES\UserBundle\Entity\MesProfile;
use MES\UserBundle\Entity\MesUser;
use MES\UserBundle\Form\MesCompanyType;
use MES\UserBundle\Form\MesProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="mes_index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/users", name="mes_users")
     * @Template()
     */
    public function usersAction()
    {
        $em    = $this->getDoctrine()->getManager();
        $users = $em->getRepository('MES\UserBundle\Entity\MesUser')->findAll();
        return ['users' => $users];
    }

    /**
     * @Route("/userEdit/{id}", name="mes_useredit")
     * @Template()
     */
    public function userEditAction(Request $request, $id)
    {
        $em   = $this->getDoctrine()->getManager();
        $user = $em->getRepository('MES\UserBundle\Entity\MesUser')->findOneBy(['id' => $id]);

        $profileForm = $this->getProfileForm($user);
        $companyForm = $this->getCompanyForm($user);
        if ($request->isMethod('POST')) {
            $request->request->set('mesUser', $user->getId());
            $companyForm->handleRequest($request);
            $profileForm->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if ($profileForm->getClickedButton() && $profileForm->isValid()) {
                $data = $profileForm->getData();
                $data->setMesUser($user);
                $em->persist($data);
            }
            if ($companyForm->getClickedButton() && $companyForm->isValid()) {
                $data = $companyForm->getData();
                $data->setMesUser($user);
                $em->persist($data);
            }
            $em->flush();
        }
        return [
            'formDetails' => $profileForm->createView(),
            'formCompany' => $companyForm->createView()
        ];
    }

    /**
     * @return Form
     */
    protected function getProfileForm(MesUser $user)
    {
        $form = $this->createForm(new MesProfileType(),
            $this->getUserProfile($user));
        $form->add('submit', 'submit',
            [
            'label' => "Zapisz",
            'attr' => [
                'class' => 'btn-default'
            ],
        ]);
        return $form;
    }

    /**
     * @return Form
     */
    protected function getCompanyForm(MesUser $user)
    {
        $form = $this->createForm(new MesCompanyType(),
            $this->getUserCompany($user));
        $form->add('submit', 'submit',
            [
            'label' => "Zapisz",
            'attr' => [
                'class' => 'btn-default'
            ],
        ]);
        return $form;
    }

    /**
     * @return MesProfile
     */
    protected function getUserProfile(MesUser $user)
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('MESUserBundle:MesProfile')->findOneBy(['mesUser' => $user]);
    }

    /**
     * @return MesCompany
     */
    protected function getUserCompany(MesUser $user)
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('MESUserBundle:MesCompany')->findOneBy(['mesUser' => $user]);
    }
}