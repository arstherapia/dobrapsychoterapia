<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\UserBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Description of CreateUserCommand
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class PromoteUserCommand extends ContainerAwareCommand {

    /**
     *
     * @var \MES\SecurityBundle\Security\Provider\MESUserProvider
     */
    private $userProvider;

    /**
     *
     * @var \MES\SecurityBundle\Security\Manager\MESUserManager
     */
    private $userManager;

    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;
    public function setUserManager(\MES\SecurityBundle\Security\Manager\MESUserManager $userManager) {
        $this->userManager = $userManager;
        return $this;
    }

    public function setUserProvider(\MES\SecurityBundle\Security\Provider\MESUserProvider $userProvider) {
        $this->userProvider = $userProvider;
        return $this;
    }
    
    public function setEntityManager(\Doctrine\ORM\EntityManager $em){
        $this->em = $em;
        return $this;
    }

    protected function configure() {
        $this
                ->setName('mes:user:promote')
                ->setDescription('Promote user')
                ->addArgument('email', InputArgument::REQUIRED, 'E-mail')
                ->addArgument('role', InputArgument::REQUIRED, 'Role')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        if (filter_var($input->getArgument('email'), FILTER_VALIDATE_EMAIL)) {
            $user = $this->userProvider->findUserBy(['email' => $input->getArgument('email')]);
            $role = $this->em->getRepository('\MES\SecurityBundle\Entity\MesUserRoles')->findOneBy(['name'=>$input->getArgument('role')]);
            $this->userManager->promoteUser($role, $user);
            $this->userProvider->updateUser($user);
        }
    }

}
