<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\APP\FrontendBundle\Twig\Extension;

use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Description of BreadcrumbsTwig
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class BreadcrumbsTwig extends Twig_Extension {

    const TEMPLATE = 'MESAPPFrontendBundle:Partials:breadcrumbs.html.twig';

    /**
     *
     * @var Twig_Environment 
     */
    private $environment;

    public function __construct(Twig_Environment $environment) {
        $this->environment = $environment;
    }

    public function getFunctions() {
        return array(
            new Twig_SimpleFunction('render_breadcrumbs', array($this, "renderBreadcrumbs")),
        );
    }

    public function getName() {
        return 'render_breadcrumbs';
    }

    public function renderBreadcrumbs(array $breadcrumbs = array()) {
        $this->environment->display(self::TEMPLATE, ['breadcrumbs' => array_merge([['content' => 'Strona główna', 'path' => 'mes_index']], $breadcrumbs)]);
    }

}
