<?php

namespace MES\APP\FrontendBundle\Controller;

use Frontend\FrontendBundle\Entity\WidgetType;
use MES\APP\FrontendBundle\Form\WidgetType as WidgetTypeForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Catagory controller.
 *
 * @Route("/")
 */
class OrderController extends Controller
{

    /**
     * Lists all Catagory entities.
     *
     * @Route("/", name="orders")
     * @Route("/", name="mes_index")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ent = $em->getRepository('OrderBundle:MesOrder')->findAll();

        return array(
            'orders' => $ent,
        );
    }

    /**
     * Lists all Catagory entities.
     *
     * @Route("/order/{id}", name="orders.order")
     * @Template()
     */
    public function orderAction(\Symfony\Component\HttpFoundation\Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $ent = $em->getRepository('OrderBundle:MesOrder')->findOneBy(['id' => $id]);
        $form = $this->createForm(new \Frontend\OrderBundle\Form\MesOrderType(), $ent);
        $form->add('submit', 'submit', ['label'=>'Zapisz']);
        if($request->isMethod('POST')){
            $form->handleRequest($request);
            $em->persist($form->getData());
            $em->flush();
            $ent = $em->getRepository('OrderBundle:MesOrder')->findOneBy(['id' => $id]);
            $this->get('mail_manager')->sendOrderStateChange($ent);
        }
        return array(
            'form' => $form->createView(),
            'entity' => $ent
        );
    }
}