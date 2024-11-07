<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
//        $user = new User();
//        $user->setLogin('admin');
//
//        $manager->persist($user);
//        $manager->flush();

        UserFactory::createMany(100);
    }
}
