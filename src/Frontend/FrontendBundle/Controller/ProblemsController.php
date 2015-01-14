<?php

namespace Frontend\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProblemsController extends Controller {

    /**
     * @Route("/problemy", name="frontend.problems.index")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        return [
            'problems' => $em->getRepository('FrontendBundle:Problems')->findAll()
        ];
    }

    /**
     * @Route("/problemy/{id}", name="frontend.problem.problem_products")
     * @Template()
     */
    public function problemPageAction($id) {
        $em = $this->getDoctrine()->getManager();
        return [
            'problem' => $em->getRepository('FrontendBundle:Problems')->findOneBy(['id' => $id])
        ];
    }

}
