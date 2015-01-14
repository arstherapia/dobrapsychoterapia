<?php

namespace Frontend\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class TherapistController extends Controller {

    /**
     * @Route("/terapeuci", name="frontend.therapist.index")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        return [
            'therapists' => $em->getRepository('FrontendBundle:Therapist')->findAll()
        ];
    }

    /**
     * @Route("/terapeuci/{id}", name="frontend.therapist.therapist_page")
     * @Template()
     */
    public function therapistPageAction($id) {
        $em = $this->getDoctrine()->getManager();
        return [
            'therapist' => $em->getRepository('FrontendBundle:Therapist')->findOneBy(['id' => $id])
        ];
    }

}
