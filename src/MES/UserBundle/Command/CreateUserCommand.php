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
class CreateUserCommand extends ContainerAwareCommand {

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

    public function setUserManager(\MES\SecurityBundle\Security\Manager\MESUserManager $userManager) {
        $this->userManager = $userManager;
        return $this;
    }

    public function setUserProvider(\MES\SecurityBundle\Security\Provider\MESUserProvider $userProvider) {
        $this->userProvider = $userProvider;
        return $this;
    }

    protected function configure() {
        $this
                ->setName('mes:user:create')
                ->setDescription('Create new user')
                ->addArgument('username', InputArgument::REQUIRED, 'Username')
                ->addArgument('email', InputArgument::REQUIRED, 'E-mail')
                ->addArgument('password', InputArgument::REQUIRED, 'Password')
                ->addArgument('name', InputArgument::REQUIRED, 'Name')
                ->addArgument('surname', InputArgument::REQUIRED, 'Surname')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        if (filter_var($input->getArgument('email'), FILTER_VALIDATE_EMAIL)) {
            $this->userManager->registerNewUser($input->getArgument('username'), $input->getArgument('email'), $input->getArgument('password'), $input->getArgument('name'), $input->getArgument('surname'));
        }
    }

}
