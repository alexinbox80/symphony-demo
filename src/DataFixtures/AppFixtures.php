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
        ProfileFactory::createMany(20, ['user' => UserFactory::new()]);

        $manager->flush();
    }
}
