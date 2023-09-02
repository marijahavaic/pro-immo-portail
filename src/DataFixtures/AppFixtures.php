<?php

namespace App\DataFixtures;

use App\Entity\Favorite;
use App\Entity\Property;
use App\Entity\User;
use Faker\Factory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'un générateur de données Faker en français
        $faker = Factory::create('fr_FR');

        // Création d'un utilisateur de test
        $user = new User();
        $user->setEmail('hello@pip.fr')
            ->setFirstName('Marija')
            ->setLastName('Dupont')
            ->setPassword('$2y$13$4UbZtgjJ2J0JSmY45CZs4uGbUbckq1R.N64JltRbz7JTVpuo3YJzi') // mdp = admin
            ->setRoles(["ROLE_ADMIN"])
            // ->setIsVerified(true)
        ;

        // Enregistrement de l'utilisateur en base de données
        $manager->persist($user);

        // Boucle pour créer 20 annonces de propriétés
        for ($i = 0; $i < 20; $i++) {
            $property = new Property();
            $property->setTitle($faker->word(6))
                ->setDescription($faker->text(200))
                ->setType($faker->word(1))
                ->setPrice($faker->numberBetween(200, 2000))
                ->setSurface($faker->numberBetween(10, 500))
                ->setAddress($faker->streetAddress())
                ->setTown($faker->city())
                ->setPostalCode($faker->numberBetween(01000, 95000))
                ->setCountry($faker->country())
                ->setPhoto($faker->imageUrl(360, 360, 'animals', true, 'dogs', true, 'jpg'))
                ->setIsRent($faker->boolean())
                ->setIsOnSale($faker->boolean())
                ->setCreatedAt($faker->dateTimeBetween('-7 months'))
                ->setUpdatedAt($faker->dateTimeBetween('-7 months'));

                $favorite = new Favorite();
                $favorite->addUser($user)
                ->addProperty($property);

                $manager->persist($favorite);

            $manager->persist($property);
        }

        $manager->flush();
    }
}
