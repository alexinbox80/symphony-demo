<?php

namespace App\DataFixtures;

use App\Factory\ProfileFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UserFactory::createMany(100);
        ProfileFactory::createMany(100);
//
//        UserFactory::new()
//            //->unpublished()
//            ->many(5)
//            ->create();

//        ProfileFactory::createMany(100, [
//            'user_id' => UserFactory::createOne()->getId(),
//        ]);

        //ProfileFactory::createMany(100, UserFactory::createOne());

        $manager->flush();
    }
}
