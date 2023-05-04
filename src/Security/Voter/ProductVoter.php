<?php

namespace App\Security\Voter;

use App\Entity\Product;
use App\Entity\User;
use LogicException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;

class ProductVoter extends Voter
{
    public const EDIT = 'PRODUCT_EDIT';
    public const DELETE = 'PRODUCT_DELETE';

    public function __construct(private Security $security)
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof Product;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        
        if (!$user instanceof User) {
            return false;
        }

        if(!$subject instanceof Product) {
            throw new LogicException("Wrong subject type provided");
        }

        if($this->security->isGranted('ROLE_ADMIN')) {
            return true;
        }

        if($attribute === self::EDIT && $subject->getUser() === $user) {
            return true;
        }

        return false;
    }
}
