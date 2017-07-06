<?php

namespace AppBundle\Security\Core\User;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseFOSUBProvider;
use Symfony\Component\Security\Core\User\UserInterface;
use AppBundle\Entity\User;

class FOSUBUserProvider extends BaseFOSUBProvider
{
    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        // get property from provider configuration by provider name
        // , it will return `facebook_id` in that case (see service definition below)
        $property = $this->getProperty($response);
        $username = $response->getUsername(); // get the unique user identifier

        //we "disconnect" previously connected users
        $existingUser = $this->userManager->findUserBy(array($property => $username));
        if (null !== $existingUser) {
            // set current user id and token to null for disconnect
            // ...

            $this->userManager->updateUser($existingUser);
        }
        // we connect current user, set current user id and token
        // ...
        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $userDetail = $response->getEmail();

        $user = $this->userManager->findUserByUsernameOrEmail($userDetail);

        $service = $response->getResourceOwner()->getName();

        // if null just create new user and set it properties
        if (null === $user) {
            if (preg_match('/codingavenue|illuminateed/', $userDetail)) {
                $username = $response->getUsername();

                $user = new User();

                $user->setUsername($username);
                $user->setPassword($service);
                $user->setEnabled(true);
                $user->setEmail($userDetail);

                if (preg_match('/nino\.labrador/', $userDetail)) {
                    $user->addRole('ROLE_ADMIN');
                }

                return $user;
            }
            else {
                return;
            }
        }

        return $user;
    }
}
