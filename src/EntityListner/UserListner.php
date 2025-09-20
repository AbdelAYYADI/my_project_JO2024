<?php

/*
namespace App\EntityListner;

use App\Entity\User;
use Doctrine\ORM\Events;
use Doctrine\Bundle\DoctrineBundle\Attribute\AsEntityListener;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



#[AsEntityListener(event: Events::preUpdate, method: 'preUpdate', entity: User::class)]
#[AsEntityListener(event: Events::prePersist, method: 'prePersist', entity: User::class)]
class UserListner
{
    private UserPasswordHasherInterface $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function prePersist(User $user)
    {
        $this->encodePassword($user);
    }

    public function preUpdate(User $user)
    {
        $this->encodePassword($user);
    }

    /**
     * Encode password based on plain password
     * @param User $user
     * @return void
     */



/*
    public function encodePassword(User $user)
    {
        if($user->getPlainPassword() === null) {
            return;
        }

        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPlainPassword());
        $user->setPassword($hashedPassword);

    }
}

*/