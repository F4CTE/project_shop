<?php

namespace App\EventSubscriber;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\EventSubscriber\EventSubscriberInterface;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordHashSubscriber implements EventSubscriberInterface
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    public function PrePersist(PrePersistEventArgs $args): void
    {
        $entity = $args->getObject();

        if (!$entity InstanceOf User) {
            return;
        }

        $entity->setPassword(
            $this->hasher->hashPassword(
                $entity,
                $entity->getPassword()
            )
            );
    }


    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist
        ];
    }
}
