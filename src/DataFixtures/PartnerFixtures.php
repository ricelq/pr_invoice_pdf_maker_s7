<?php

namespace App\DataFixtures;

use App\Entity\Partner;
use App\Entity\Post;
use App\Entity\Tag;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

use Symfony\Component\String\Slugger\SluggerInterface;

class PartnerFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(private readonly SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadPartners($manager);

    }

    public function loadPartners($manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new \Faker\Provider\de_CH\Company($faker));
        $faker->addProvider(new \Faker\Provider\de_CH\Address($faker));

        for ($i = 1; $i < 10; $i++) {
            $partner = new Partner();

            $partner
                ->setName($faker->unique()->company())
                ->setAddress($faker->address())
                ->setCountry('Switzerland')
                ->setPostal($faker->postcode())
                ->setCity($faker->city())
                ->setName($faker->company())
                ->setUser($this->getReference('userFixture' . rand(1, 9)));
            $manager->persist($partner);

            $this->addReference('partnerFixture' . $i, $partner);

        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [UserFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['partner'];
    }
}
