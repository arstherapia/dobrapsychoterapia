<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\APP\FrontendBundle\Twig\Extension;

use Symfony\Component\Security\Core\SecurityContext;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Description of MenuTwig
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class MenuTwig extends Twig_Extension {

    const TEMPLATE = 'MESAPPFrontendBundle:Partials:navigation.html.twig';

    private $environment;
    private $securityContext;

    public function __construct(SecurityContext $securityContext, Twig_Environment $environment) {
        $this->securityContext = $securityContext;
        $this->environment = $environment;
    }

    public function getFunctions() {
        return array(
            new Twig_SimpleFunction('admin_menu', array($this, "renderMenu")),
        );
    }

    public function getName() {
        return 'admin_menu';
    }

    public function renderMenu() {
        $this->environment->display(self::TEMPLATE);
    }

}
