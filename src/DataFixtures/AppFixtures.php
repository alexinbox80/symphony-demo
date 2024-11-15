<?php

namespace App\DataFixtures;

use App\Factory\BookFactory;
use App\Factory\ProfileFactory;
use App\Factory\ShelfFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        ProfileFactory::createMany(100, ['user' => UserFactory::new()]);

        BookFactory::createMany(100, ['shelf' => ShelfFactory::new()]);

        $manager->flush();
    }
}
