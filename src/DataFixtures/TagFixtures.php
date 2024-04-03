<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TagFixtures extends Fixture implements FixtureGroupInterface
{
    public function load(ObjectManager $manager): void
    {
        $this->loadTags($manager);
    }

    public function loadTags($manager): void
    {
        $faker = Factory::create();
        //$faker->addProvider(new Company($faker));

        for ($i = 0; $i < 5; $i++) {
            $tag = new Tag();
            $tag
                ->setName($faker->words(1, true));

            $manager->persist($tag);
            $this->addReference('tagFixture' . $i, $tag);
        }
        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['tag'];
    }
}
