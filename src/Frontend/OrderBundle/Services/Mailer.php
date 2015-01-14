<?php

namespace Frontend\OrderBundle\Services;

use Doctrine\ORM\EntityManager;
use Frontend\OrderBundle\Entity\MesOrder;
use Swift_Mailer;
use Swift_Message;
use Twig_Environment;

/**
 * Description of MailSpam
 *
 * @author Marcin Bonk <marcin.bonk@gowork.pl>
 */
class Mailer {

    protected $em;
    protected $mailer;
    protected $twig;

    public function __construct(EntityManager $em, Swift_Mailer $mailer, Twig_Environment $twig) {
        $this->entityManager = $em;
        $this->swiftMailer = $mailer;
        $this->twig = $twig;
    }

    public function sendOrderConfirmation(MesOrder $order) {
        $message = Swift_Message::newInstance()
                ->setSubject("Potwierdzenie zamówienia")
                ->setFrom("sklep@dobrapsychoterapia.net")
                ->setTo($order->getEmail())
                ->setBody($this->twig->render('OrderBundle:Mail:MesOrder.html.twig', ['order' => $order]), 'text/html'); //dodaj serwis twig

        $this->swiftMailer->send($message);



        $message = Swift_Message::newInstance()
                ->setSubject("SUKCES: Potwierdzenie zamówienia")
                ->setFrom("sklep@dobrapsychoterapia.net")
                ->setTo('sklep@dobrapsychoterapia.net')
                ->setBody($this->twig->render('OrderBundle:Mail:MesOrder.html.twig', ['order' => $order]), 'text/html'); //dodaj serwis twig

        $this->swiftMailer->send($message);
    }

    public function sendContact(\Frontend\FrontendBundle\Entity\Contact $contact) {
        if ($contact->getCopy()) {
            $message = Swift_Message::newInstance()
                    ->setSubject("Potwierdzenie wysłania wiadomości")
                    ->setFrom("sklep@dobrapsychoterapia.net")
                    ->setTo($contact->getEmail())
                    ->setBody($this->twig->render('OrderBundle:Mail:MesContact.html.twig', ['contact' => $contact]), 'text/html'); //dodaj serwis twig

            $this->swiftMailer->send($message);
        }
        $message = Swift_Message::newInstance()
                ->setSubject("Formularz kontaktowy: ".$contact->getSubject())
                ->setFrom("sklep@dobrapsychoterapia.net")
                ->setTo('sklep@dobrapsychoterapia.net')
                ->setBody($this->twig->render('OrderBundle:Mail:MesContact.html.twig', ['contact' => $contact]), 'text/html'); //dodaj serwis twig

        $this->swiftMailer->send($message);
    }

    public function sendOrderStateChange(MesOrder $order){
        $message = Swift_Message::newInstance()
                    ->setSubject("Potwierdzenie wysłania wiadomości")
                    ->setFrom("sklep@dobrapsychoterapia.net")
                    ->setTo($order->getEmail())
                    ->setBody($this->twig->render('OrderBundle:Mail:MesOrderState.html.twig', ['order' => $order]), 'text/html'); //dodaj serwis twig

            $this->swiftMailer->send($message);
    }

    public function sendUserCreateEmail(\MES\UserBundle\Entity\MesUser $user){
        $message = Swift_Message::newInstance()
                    ->setSubject("Potwierdzenie wysłania wiadomości")
                    ->setFrom("sklep@dobrapsychoterapia.net")
                    ->setTo($user->getEmail())
                    ->setBody($this->twig->render('MESSecurityBundle:Register:mail.html.twig', ['user' => $user]), 'text/html'); //dodaj serwis twig

            $this->swiftMailer->send($message);
    }

}
