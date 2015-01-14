<?php

namespace Frontend\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller {

    /**
     * @Route("/", name="frontend.default.index")
     * @Template()
     */
    public function indexAction() {
        return [];
    }

    /**
     * @Route("/onas", name="frontend.default.about")
     * @Template()
     */
    public function aboutAction() {
        return [];
    }

    /**
     * @Route("/nasze-filmy", name="frontend.default.our_movies")
     * @Template()
     */
    public function ourMoviesAction() {
        return [];
    }

    /**
     * @Route("/nowe-zamowienie", name="frontend.default.order_creation")
     * @Template()
     */
    public function orderCreationAction() {
        return [];
    }

    /**
     * @Route("/wysylka-i-platnosci", name="frontend.default.shiping")
     * @Template()
     */
    public function shipingAction() {
        return [];
    }

    /**
     * @Route("/regulamin", name="frontend.default.regulamin")
     * @Template()
     */
    public function regulaminAction() {
        return [];
    }

    /**
     * @Route("/kontakt", name="frontend.default.contact")
     * @Template()
     */
    public function contactAction(\Symfony\Component\HttpFoundation\Request $request) {
        $form = $this->createForm(new \Frontend\FrontendBundle\Form\ContactType());
        $form->add('submit', 'submit');
        if($request->isMethod("POST")){
            $form->handleRequest($request);
            if($form->isValid()){
                $em = $this->getDoctrine()->getManager();
                $em->persist($form->getData());
                $em->flush();
                $this->get('mail_manager')->sendContact($form->getData());
                $this->get('session')->getFlashBag()->add('success', 'Wiadomość wysłana pomyślnie');
            }
        }
        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Route("/aktualnosci", name="frontend.default.news")
     * @Template()
     */
    public function newsAction() {
        return [];
    }
}
