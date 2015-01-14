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
 * @Route("/widget")
 */
class WidgetController extends Controller {

    /**
     * Lists all Catagory entities.
     *
     * @Route("/premiere", name="premiere")
     * @Method("GET")
     * @Template()
     */
    public function premiereAction() {
        $em = $this->getDoctrine()->getManager();

        $ent = $em->getRepository('FrontendBundle:Widget')->findOneBy([
            'widgetType' => WidgetType::PREMIERE
        ]);
        $form = $this->createForm(new WidgetTypeForm(), $ent);
        $form->add('submit', 'submit', [
            'label' => 'Zapisz'
        ]);
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Lists all Catagory entities.
     *
     * @Route("/premiere", name="premiere.post")
     * @Method("POST")
     */
    public function premierePostAction(\Symfony\Component\HttpFoundation\Request $request) {
        $em = $this->getDoctrine()->getManager();

        $ent = $em->getRepository('FrontendBundle:Widget')->findOneBy([
            'widgetType' => WidgetType::PREMIERE
        ]);
        $form = $this->createForm(new WidgetTypeForm(), $ent);
        $form->handleRequest($request);
        $em->persist($form->getData());
        $em->flush();

        return $this->redirect($this->generateUrl('premiere'));
    }

    /**
     * Lists all Catagory entities.
     *
     * @Route("/newest", name="newest")
     * @Method("GET")
     * @Template()
     */
    public function newestAction() {
        $em = $this->getDoctrine()->getManager();

        $ent = $em->getRepository('FrontendBundle:Widget')->findOneBy([
            'widgetType' => WidgetType::NEWS
        ]);
        $form = $this->createForm(new WidgetTypeForm(), $ent);
        $form->add('submit', 'submit', [
            'label' => 'Zapisz'
        ]);
        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Lists all Catagory entities.
     *
     * @Route("/newest", name="newest.post")
     * @Method("POST")
     */
    public function newestPostAction(\Symfony\Component\HttpFoundation\Request $request) {
        $em = $this->getDoctrine()->getManager();

        $ent = $em->getRepository('FrontendBundle:Widget')->findOneBy([
            'widgetType' => WidgetType::NEWS
        ]);
        $form = $this->createForm(new WidgetTypeForm(), $ent);
        $form->handleRequest($request);
        $em->persist($form->getData());
        $em->flush();

        return $this->redirect($this->generateUrl('newest'));
    }

}
