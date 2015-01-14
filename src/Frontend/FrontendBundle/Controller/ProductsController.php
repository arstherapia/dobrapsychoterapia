<?php

namespace Frontend\FrontendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ProductsController extends Controller {

    /**
     * @Route("/produkt/{id}", name="frontend.products.display")
     * @Template()
     */
    public function displayAction($id) {
        $em = $this->getDoctrine()->getManager();
        return [
            'product' => $em->getRepository('FrontendBundle:Movies')->findOneBy(['id' => $id])
        ];
    }

}
