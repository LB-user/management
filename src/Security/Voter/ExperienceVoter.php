<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Experience;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class ExperienceVoter extends Voter
{
    const EXPERIENCE_EDIT = 'experience_edit';
    const EXPERIENCE_DELETE = 'experience_delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    
    protected function supports(string $attribute, $experience): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EXPERIENCE_EDIT, self::EXPERIENCE_DELETE])
            && $experience instanceof \App\Entity\Experience;
    }

    protected function voteOnAttribute(string $attribute, $experience, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')) return true;

        if (null === $experience->getUser()) return false;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::EXPERIENCE_EDIT:
                return $this->canEdit($experience, $user);
                break;
            case self::EXPERIENCE_DELETE:
                return $this->canDelete($experience, $user);
                break;
        }

        return false;
    }

    private function canEdit(Experience $experience, User $user)
    {
        return $user === $experience->getUser();
    }

    private function canDelete(Experience $experience, User $user)
    {
        return $user === $experience->getUser();
    }
}
