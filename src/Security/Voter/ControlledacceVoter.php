<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ControlledacceVoter extends Voter
{
    protected function supports($attribute, $subject)
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, ['POST', 'DELETE'])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute($attribute, $subject, TokenInterface $token)
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }
        if($user->getRoles()[0] === 'ROLE_SUPER_ADMIN' && 
        ($subject->getProfil()->getLibelle() != 'ROLE_SUPER_ADMIN'))
         {
           
            return true;
         }
         //dd($user);
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            //gerer les droits de creation
            case 'POST':
                if($user->getRoles()[0] === 'ROLE_ADMIN' && 
                ($subject->getProfil()->getLibelle() === 'CAISSIER'||
                $subject->getProfil()->getLibelle() === 'PARTENAIRE'))
                 {
                   return true;
                 }elseif($user->getRoles()[0] === 'CAISSIER')
                 {
                   return false;
                 }

                 if($user->getRoles()[0] === 'ROLE_PARTENAIRE' && 
                ($subject->getProfil()->getLibelle() === 'ADMIN_PARTENAIRE'||
                $subject->getProfil()->getLibelle() === 'CAISSIER_PARTENAIRE'))
                 {
                   return true;
                 }elseif($user->getRoles()[0] === 'CAISSIER_PARTENAIRE')
                 {
                   return false;
                 }
                break;
            case 'DELETE':
                if($user->getRoles()[0] === 'ROLE_SUPER_ADMIN' && 
                ($subject->getRoles()[0] != 'SUPER_ADMIN'))
                 {
                    return true;
                 }
                break;
        }

        return false;
    }
}
