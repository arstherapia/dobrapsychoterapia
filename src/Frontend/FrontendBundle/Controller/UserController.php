<?php

namespace Frontend\FrontendBundle\Controller;

use MES\UserBundle\Entity\MesCompany;
use MES\UserBundle\Entity\MesProfile;
use MES\UserBundle\Form\MesCompanyType;
use MES\UserBundle\Form\MesProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/uzytkownik")
 */
class UserController extends Controller
{

    /**
     * @Route("/", name="frontend.user.index")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/moje-dane", name="frontend.user.details")
     * @Template()
     */
    public function detailsAction(Request $request)
    {
        $profileForm = $this->getProfileForm();
        $companyForm = $this->getCompanyForm();
        if ($request->isMethod('POST')) {
            $request->request->set('mesUser', $this->getUser()->getId());
            $companyForm->handleRequest($request);
            $profileForm->handleRequest($request);
            $em = $this->getDoctrine()->getManager();
            if ($profileForm->getClickedButton() && $profileForm->isValid()) {
                $data = $profileForm->getData();
                $data->setMesUser($this->getUser());
                $em->persist($data);
            }
            if ($companyForm->getClickedButton() && $companyForm->isValid()) {
                $data = $companyForm->getData();
                $data->setMesUser($this->getUser());
                $em->persist($data);
                $em->flush();
            }
        }
        return [
            'formDetails' => $profileForm->createView(),
            'formCompany' => $companyForm->createView()
        ];
    }

    /**
     * 
     * @return Form
     */
    protected function getProfileForm()
    {
        $form = $this->createForm(new MesProfileType(), $this->getUserProfile());
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
     * 
     * @return Form
     */
    protected function getCompanyForm()
    {
        $form = $this->createForm(new MesCompanyType(), $this->getUserCompany());
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
     * 
     * @return MesProfile
     */
    protected function getUserProfile()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('MESUserBundle:MesProfile')->findOneBy(['mesUser' => $this->getUser()->getId()]);
    }

    /**
     * 
     * @return MesCompany
     */
    protected function getUserCompany()
    {
        $em = $this->getDoctrine()->getManager();
        return $em->getRepository('MESUserBundle:MesCompany')->findOneBy(['mesUser' => $this->getUser()->getId()]);
    }

    /**
     * @Route("/moje-zamowienia/{orderId}", name="frontend.user.orders")
     * @Template()
     */
    public function ordersAction($orderId = null)
    {
        $products = [];
        if (is_numeric($orderId)) {
            /* @var $order \Frontend\OrderBundle\Entity\MesOrder */
            $order = $this->getDoctrine()->getManager()->getRepository('Frontend\OrderBundle\Entity\MesOrder')->findOneBy(['id' => $orderId]);
            if ($order->getMesUser()->contains($this->getUser())) {
                $products = ['order' => $order];
            }
        }
        return $products;
    }
}