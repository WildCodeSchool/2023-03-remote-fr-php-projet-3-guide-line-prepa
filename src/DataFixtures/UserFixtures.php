<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private readonly UserPasswordHasherInterface $userPasswordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail('user@test.com')
            ->setNickname('User 1')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'password'));
        $manager->persist($user);

        $admin = new User();
        $admin
            ->setEmail('admin@test.com')
            ->setNickname('Admin 1')
            ->setPassword($this->userPasswordHasher->hashPassword($admin, 'password'))
            ->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);
        $manager->flush();
    }
}
