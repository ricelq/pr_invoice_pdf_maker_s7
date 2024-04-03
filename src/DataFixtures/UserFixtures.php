<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Person;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\GroupSequence;
use Symfony\Component\Validator\GroupProviderInterface;

class UserFixtures extends Fixture implements GroupProviderInterface
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadUserAdmin($manager);
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager): void
    {
        $faker = Factory::create();
        $faker->addProvider(new Person($faker));
        $isVerified = [true, false];

        for ($i = 0; $i < 10; $i++) {
            $user = (new User());
            $user
                ->setUsername($faker->unique()->userName())
                ->setEmail($faker->unique()->email())
                ->setPassword($this->userPasswordHasher->hashPassword($user, $faker->password()))
                ->setIsVerified($faker->randomElement($isVerified))
                ->setRoles(['ROLE_USER']);

            $manager->persist($user);
            $this->addReference('userFixture' . $i, $user);
        }
        $manager->flush();
    }

    private function loadUserAdmin(ObjectManager $manager): void
    {
        $user = (new User());
        $user
            ->setUsername('admin')
            ->setEmail('admin@domain.com')
            ->setPassword($this->userPasswordHasher->hashPassword($user, 'admin'))
            ->setIsVerified(true)
            ->setRoles(['ROLE_ADMIN']);

        $manager->persist($user);
        $manager->flush();
    }

    public function getGroups(object $object): array|GroupSequence
    {
        return ['user'];
    }
}


