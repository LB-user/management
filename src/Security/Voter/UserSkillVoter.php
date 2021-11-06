<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\UserSkill;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserSkillVoter extends Voter
{
    const USERSKILL_EDIT = 'userskill_edit';
    const USERSKILL_DELETE = 'userskill_delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    protected function supports(string $attribute, $userskill): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::USERSKILL_EDIT,self::USERSKILL_DELETE])
            && $userskill instanceof \App\Entity\UserSkill;
    }

    protected function voteOnAttribute(string $attribute, $userskill, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')) return true;

        if (null === $userskill->getUserId()) return false;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::USERSKILL_EDIT:
                return $this->canEdit($userskill, $user);
                break;
            case self::USERSKILL_DELETE:
                return $this->canDelete($userskill, $user);
                break;
        }

        return false;
    }

    private function canEdit(UserSkill $userskill, User $user)
    {
        return $user === $userskill->getUserId();
    }

    private function canDelete(UserSkill $userskill, User $user)
    {
        return $user === $userskill->getUserId();
    }
}
