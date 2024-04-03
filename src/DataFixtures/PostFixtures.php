<?php

namespace App\DataFixtures;

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

class PostFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(private readonly SluggerInterface $slugger, EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadPosts($manager);

    }

    public function loadPosts($manager): void
    {
        $faker = Factory::create();

        $users = $this->entityManager->getRepository(User::class)->findAll();
        $tags = $this->entityManager->getRepository(Tag::class)->findAll();


        for ($i = 1; $i < 10; $i++) {
            $post = new Post();
            $title = $faker->words(3, true);
            $publishedAt = new \DateTimeImmutable();

            $post
                ->setTitle($title)
                ->setSlug($this->slugger->slug($title))
                ->setSummary($faker->words(6, true))
                ->setBody($faker->words(15, true))
                ->addTag($faker->randomelement($tags))
                ->setPublishedAt($publishedAt)
                ->setAuthor($this->getReference('userFixture' . $i));
            $manager->persist($post);
        }
        $manager->flush();
    }


    public function getDependencies()
    {
        return [TagFixtures::class, UserFixtures::class];
    }

    public static function getGroups(): array
    {
        return ['post'];
    }
}
