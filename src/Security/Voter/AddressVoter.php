<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Address;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class AddressVoter extends Voter
{
    const ADDRESS_EDIT = 'address_edit';

    private $security;

    public function __construct(Security $security){
        $this->security = $security;
    }

    protected function supports(string $attribute, $address): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::ADDRESS_EDIT])
            && $address instanceof \App\Entity\Address;
    }

    protected function voteOnAttribute(string $attribute, $address, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access

        if (!$user instanceof UserInterface) {
            return false;
        }

        if($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')) return true;

        if(null === $address->getUser()) return false;
        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::ADDRESS_EDIT:
                return $this->canEdit($address, $user);
                break;
        }

        return false;
    }

    private function canEdit(Address $address, User $user){
        return $user === $address->getUser();
    }
}
