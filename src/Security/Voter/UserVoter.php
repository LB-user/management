<?php

namespace App\Security\Voter;

use App\Entity\User;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class UserVoter extends Voter
{
    const USER_EDIT = 'user_edit';
    const USER_DELETE = 'user_delete';
    const USER_SHOW = 'user_show';
    const USER_EDIT_PASSWORD = 'user_edit_password';
    const USER_CV = 'user_cv';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $userp): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::USER_EDIT, self::USER_DELETE, self::USER_SHOW, self::USER_EDIT_PASSWORD, self::USER_CV])
            && $userp instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, $userp, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')) return true;

        if (null === $userp) return false;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::USER_EDIT:
                return $this->canEdit($userp, $user);
                break;
            case self::USER_DELETE:
                return $this->canDelete($userp, $user);
                break;
            case self::USER_SHOW:
                return $this->canShow($userp, $user);
                break;
            case self::USER_EDIT_PASSWORD:
                return $this->canEditPassword($userp, $user);
                break;
            case self::USER_CV:
                return $this->canEditCv($userp, $user);
                break;
        }

        return false;
    }
    private function canEdit(User $userp, $user)
    {
        return $user === $userp;
    }
    private function canDelete(User $userp, $user)
    {
        return $user === $userp;
    }
    private function canShow(User $userp, $user)
    {
        return $user === $userp;
    }
    private function canEditPassword(User $userp, $user)
    {
        return $user === $userp;
    }
    private function canEditCv(User $userp, $user)
    {
        return $user === $userp;
    }
}
