<?php

namespace Frontend\OrderBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use Frontend\FrontendBundle\Entity\Movies;
use Frontend\OrderBundle\Entity\MesOrder;
use Frontend\OrderBundle\Entity\OrderProducts;
use Frontend\OrderBundle\Form\OrderForm;
use Frontend\OrderBundle\Services\Mailer;
use Frontend\OrderBundle\Services\OrderManager;
use MES\SecurityBundle\Security\MesUserInterface;
use MES\UserBundle\Entity\MesCompany;
use MES\UserBundle\Entity\MesProfile;
use MES\UserBundle\Form\MesCompanyType;
use MES\UserBundle\Form\MesProfileType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

    /**
     * @Route("/podglad-zamowienia", name="order.default.index")
     * @Template()
     */
    public function indexAction(Request $request) {
        $form = $this->createForm(new OrderForm(), ['shiping' => $this->getUserProfile(), 'company' => $this->getUserCompany(), 'email' => ($this->getUser()) ? $this->getUser()->getEmail() : null]);
        if ($request->isMethod('POST')) {
            if ($request->cookies->has('cart')) {
                $data = (json_decode($request->cookies->get('cart')));
            }
            $shiping = $request->request->get('shiping_type');
            $request->request->remove('shiping_type');
            if (count($data) > 0) {
                $form->handleRequest($request);
                if ($form->isValid()) {
                    /* @var $orderManager OrderManager */
                    $orderManager = $this->get('order_manager');
                    $order = $orderManager->handleOrder($form->getData()['shiping'], $this->getProducts($data), $form->getData()['email'], $this->getUser(), $form->getData()['company']);
                    if($shiping == 16){
                        $order->setShipping(MesOrder::PRZ);
                    }else{
                        $order->setShipping(MesOrder::POB);
                    }
                    if ($order instanceof MesOrder) {
                        $orderManager->saveOrder($order);
                        if($this->getUser()){$this->get('mes_user_provider')->updateUser($this->getUser());}
                        $this->get('session')->set('order', $order->getId());
                        return $this->redirect($this->generateUrl('order.default.create'));
                    }
                }
            }
        }
        return [
            'form' => $form->createView()
        ];
    }

    private function getProducts(array $stuff) {
        $collection = new ArrayCollection();
        foreach ($stuff as $item) {
            $product = new OrderProducts();
            /* @var $element Movies */
            $element = $this->getDoctrine()->getManager()->getRepository('Frontend\FrontendBundle\Entity\Movies')->findOneBy(['id' => $item->id]);
            $product
                    ->setQuantity($item->quantity)
                    ->setMovies($element)
            ;
            if ($item->type == 'ind') {
                $product->setProductPriceNett($element->getIndividualPrice());
            } else {
                $product->setProductPriceNett($element->getProffesionalPrice());
            }
            $collection->add($product);
        }
        return $collection;
    }

    /**
     * @Route("/zamowienie", name="order.default.create")
     * @Method({"GET"})
     * @Template()
     */
    public function createAction(Request $request) {
        if ($this->get("session")->has('order')) {
            
            $orderId = $this->get('session')->get('order');
            $this->get("session")->remove('order');
            /* @var $mailer Mailer */
            $mailer = $this->get('mail_manager');
            $mailer->sendOrderConfirmation($this->getDoctrine()->getManager()->getRepository('Frontend\OrderBundle\Entity\MesOrder')->find($orderId));
            return [];
        }else{
            return $this->redirect($this->generateUrl('frontend.default.index'));
        }
    }

    /**
     * 
     * @return Form
     */
    protected function getProfileForm() {
        $form = $this->createForm(new MesProfileType(), $this->getUserProfile());
        return $form;
    }

    /**
     * 
     * @return Form
     */
    protected function getCompanyForm() {
        $form = $this->createForm(new MesCompanyType(), $this->getUserCompany());
        return $form;
    }

    /**
     * 
     * @return MesProfile
     */
    protected function getUserProfile() {
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser() instanceof MesUserInterface) {
            return $em->getRepository('MESUserBundle:MesProfile')->findOneBy(['mesUser' => $this->getUser()->getId()]);
        } else {
            return null;
        }
    }

    /**
     * 
     * @return MesCompany
     */
    protected function getUserCompany() {
        $em = $this->getDoctrine()->getManager();
        if ($this->getUser() instanceof MesUserInterface) {
            return $em->getRepository('MESUserBundle:MesCompany')->findOneBy(['mesUser' => $this->getUser()->getId()]);
        } else {
            return null;
        }
    }

}
