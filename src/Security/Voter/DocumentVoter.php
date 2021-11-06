<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Entity\Document;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class DocumentVoter extends Voter
{
    const DOCUMENT_EDIT = 'document_edit';
    const DOCUMENT_DELETE = 'document_delete';

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $document): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::DOCUMENT_EDIT, self::DOCUMENT_DELETE])
            && $document instanceof \App\Entity\Document;
    }

    protected function voteOnAttribute(string $attribute, $document, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        if ($this->security->isGranted('ROLE_ADMIN') || $this->security->isGranted('ROLE_SUPER_ADMIN')) return true;

        // ... (check conditions and return true to grant permission) ...
        switch ($attribute) {
            case self::DOCUMENT_EDIT:
                return $this->canEdit($document, $user);
                break;
            case self::DOCUMENT_DELETE:
                return $this->canDelete($document, $user);
                break;
        }

        return false;
    }

    private function canEdit(Document $document, $user)
    {
        return $user->getId() === $document->getUser()->getId();
    }

    private function canDelete(Document $document, $user)
    {
        return $user->getId() === $document->getUser()->getId();
    }
}