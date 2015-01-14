<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MES\SecurityBundle\Authenticator;

use MES\SecurityBundle\Security\Token\MESToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\SimpleFormAuthenticatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Description of MESAuthenticator
 *
 * @author Marcin Bonk <marvcin@gmail.com>
 */
class MESAuthenticator implements SimpleFormAuthenticatorInterface {

    private $encoderFactory;

    public function __construct(EncoderFactoryInterface $encoderFactory) {
        $this->encoderFactory = $encoderFactory;
    }

    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey) {
        try {
            $user = $userProvider->loadUserByUsername($token->getUsername());
        } catch (UsernameNotFoundException $e) {
            throw new AuthenticationException('Invalid username or password');
        }
        $passwordValid = ($user->getPassword() == $this->encoderFactory->getEncoder($user)->encodePassword($token->getCredentials(), $user->getSalt()));
        if ($passwordValid) {
            if (count($user->getRoles()) > 0) {
                $token = new MESToken($user, $user->getPassword(), $providerKey, $user->getRoles());
                return $token;
            }
            throw new AuthenticationException('User has no roles');
        }
        throw new AuthenticationException('Invalid username or password');
    }

    public function supportsToken(TokenInterface $token, $providerKey) {
        return $token instanceof MESToken && $token->getProviderKey() === $providerKey;
    }

    public function createToken(Request $request, $username, $password, $providerKey, $roles = array()) {
        return new MESToken($username, $password, $providerKey, $roles);
    }

}
