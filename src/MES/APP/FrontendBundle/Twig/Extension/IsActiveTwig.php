<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\APP\FrontendBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Description of BreadcrumbsTwig
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class IsActiveTwig extends Twig_Extension
{
    /**
     *
     * @var RequestStack
     */
    private $requestStack;
    
    public function __construct(RequestStack $requestStack){
        $this->requestStack = $requestStack;
    }
    
    public function getFunctions()
    {
        return array(
            new Twig_SimpleFunction('current_route', array($this, 'currentRoute')),
        );
    }

    public function currentRoute(array $route, $bool = false)
    {
        if($bool){
            return (in_array($this->requestStack->getCurrentRequest()->get('_route'), $route))?'':'collapse';
        }
        return (in_array($this->requestStack->getCurrentRequest()->get('_route'), $route))?'active':'';
    }

    public function getName()
    {
        return 'route_filter';
    }
}
