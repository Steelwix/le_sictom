<?php

namespace App\Security\Voter;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class RoleVoter extends Voter
{
    public const ISADMIN = 'ISADMIN';
    public const ISUSER = 'ISUSER';

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ISADMIN, self::ISUSER])
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ISADMIN:
                return $this->isAdmin($user);
                break;
                break;
            case self::ISUSER:
                return $this->isUser($user);
                break;
                break;
        }

        return false;
    }
    private function isAdmin($user)
    {
        if ($user->getRoles() == ["ROLE_ADMIN", "ROLE_USER"] || $user->getRoles() == ["ROLE_ADMIN"]) {
            return true;
        }
        return false;
    }
    private function isUser($user)
    {
        if ($user->getRoles() == ["ROLE_USER"]) {
            return true;
        }
        return false;
    }
}
