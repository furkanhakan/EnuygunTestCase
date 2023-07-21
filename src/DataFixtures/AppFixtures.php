<?php

namespace App\DataFixtures;

use App\Entity\Developer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 5; $i++) {
            $developer = (new Developer())
                ->setName('DEV' . $i)
                ->setLevel($i)
                ->setDuration(1);

            $manager->persist($developer);
        }

        $manager->flush();
    }
}
