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
        //UserFactory::createMany(100);
        //ProfileFactory::createMany(100);

        UserFactory::createMany(6, ['profile' => ProfileFactory::new()]);

        $manager->flush();
    }
}
