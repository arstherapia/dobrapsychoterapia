<?php

namespace Frontend\FrontendBundle\Twig\Extension;

use Doctrine\ORM\EntityManager;
use Frontend\FrontendBundle\Entity\WidgetType;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\SecurityContext;
use Twig_Environment;
use Twig_Extension;
use Twig_SimpleFunction;

/**
 * Description of MenuExtension
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class MenuExtension extends Twig_Extension {

    const TEMPLATE = 'FrontendBundle:Functions:menu.html.twig';
    const HEADER = 'FrontendBundle:Functions:headerMenu.html.twig';
    const FOOTER = 'FrontendBundle:Functions:footer.html.twig';
    const RELASES = 'FrontendBundle:Functions:relases.html.twig';
    const NEW_THINGS = 'FrontendBundle:Functions:newThings.html.twig';
    const COMMON_THINGS = 'FrontendBundle:Functions:commonInfo.html.twig';
    const MOVIES_OF_THE_MONTH = 'FrontendBundle:Functions:moviesOfTheMonth.html.twig';
    const MASTERS = 'FrontendBundle:Functions:masters.html.twig';

    private $environment;
    private $securityContext;
    private $em;
    private $formFactory;
    private $requestStack;

    public function __construct(SecurityContext $securityContext, Twig_Environment $environment, EntityManager $em, FormFactory $formFactory, RequestStack $requestStack) {
        $this->securityContext = $securityContext;
        $this->environment = $environment;
        $this->em = $em;
        $this->formFactory = $formFactory;
        $this->requestStack = $requestStack;
    }

    public function getFunctions() {
        return array(
            new Twig_SimpleFunction('menu', array($this, "renderMenu")),
            new Twig_SimpleFunction('render_header', array($this, "renderHeader")),
            new Twig_SimpleFunction('render_footer', array($this, "renderFooter")),
            new Twig_SimpleFunction('render_relases', array($this, "renderRelases")),
            new Twig_SimpleFunction('render_new_things', array($this, "renderNewThings")),
            new Twig_SimpleFunction('render_common_info', array($this, "renderCommonInfo")),
            new Twig_SimpleFunction('render_movies_of_the_month', array($this, "renderMoviesOfTheMonth")),
            new Twig_SimpleFunction('render_masters', array($this, "renderMasters")),
        );
    }

    public function getName() {
        return 'menu';
    }

    public function renderHeader() {
        $this->environment->display(self::HEADER);
    }

    public function renderMenu() {
        $this->environment->display(self::TEMPLATE);
    }

    public function renderFooter() {
        $form = $this->formFactory->create(new \Frontend\FrontendBundle\Form\NewsletterType());
        $form->add('submit', 'submit', [
            'attr' => ['class' => 'button']
        ]);
        if ($this->requestStack->getCurrentRequest()->isMethod('POST')) {
            $form->handleRequest($this->requestStack->getCurrentRequest());
            if($form->isValid()){
                $this->em->persist($form->getData());
                $this->em->flush();
                $this->requestStack->getCurrentRequest()->getSession()->getFlashBag()->add('success', 'Pomyślnie zapisano do newslettera');
            }
        }
        $this->environment->display(self::FOOTER, [
            'newsletter' => $form->createView(),
            'catagories' => $this->em->getRepository('FrontendBundle:Catagory')->findBy([], [], 10)
        ]);
    }

    public function renderRelases() {
        $relases = $this->em->getRepository('FrontendBundle:Widget')->findOneBy([
            'widgetType' => WidgetType::PREMIERE
        ]);
        $this->environment->display(self::RELASES, ['relases' => $relases]);
    }

    public function renderNewThings() {
        $relases = $this->em->getRepository('FrontendBundle:Widget')->findOneBy([
            'widgetType' => WidgetType::NEWS
        ]);
        $this->environment->display(self::NEW_THINGS, ['relases' => $relases]);
    }

    public function renderCommonInfo() {
        $this->environment->display(self::COMMON_THINGS);
    }

    public function renderMoviesOfTheMonth() {
        $this->environment->display(self::MOVIES_OF_THE_MONTH);
    }

    public function renderMasters() {
        $this->environment->display(self::MASTERS);
    }

}
