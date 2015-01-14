<?php

namespace Frontend\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CatagoriesController extends Controller {

    /**
     * @Route("/kategorie", name="frontend.catagories.index")
     * @Template()
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        return [
            'catagories' => $em->getRepository('FrontendBundle:Catagory')->findAll()
        ];
    }

    /**
     * @Route("/kategorie/{id}", name="frontend.catagories.catagory_products")
     * @Template()
     */
    public function catagoryProductsAction($id) {
        $em = $this->getDoctrine()->getManager();
        /* @var $catagory \Frontend\FrontendBundle\Entity\Catagory */
        $catagory = $em->getRepository('FrontendBundle:Catagory')->findOneBy(['id' => $id]);
        return [
            'catagory' => $catagory
        ];
    }

}
