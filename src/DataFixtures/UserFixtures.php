<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    protected $faker;
    protected $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        // Faker en langue française :
        $this->faker = Factory::create('fr_FR');
        // le service qui hache les mots de passe :
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        // 1. Le gérant (compte unique)
        $gerant = new User;
        $gerant->setEmail('gerant@garage.fr')
            ->setNom('Lain')
            ->setPrenom('Jean')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->hasher->hashPassword($gerant, 'password'));

        $manager->persist($gerant);

        // 2. Le personnel : 3 comptes
        for ($i = 1; $i <= 3; $i++) {
            $staff = new User;
            $staff->setEmail('staff' . $i . '@garage.fr')
                ->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName())
                ->setTelephone($this->faker->phoneNumber())
                ->setRoles(['ROLE_STAFF'])
                ->setPassword($this->hasher->hashPassword($staff, 'password'));

            $manager->persist($staff);
        }

        // 3. Les clients : 10 comptes
        for ($i = 1; $i <= 10; $i++) {
            $client = new User;
            $client->setEmail('client' . $i . '@garage.fr')
                ->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName())
                ->setTelephone($this->faker->phoneNumber())
                ->setDateNaissance($this->faker->dateTimeBetween('-60 years', '-21 years'))
                ->setAdresse($this->faker->streetAddress())
                ->setCodePostal($this->faker->postcode())
                ->setVille($this->faker->city())
                ->setDatePermis($this->faker->dateTimeBetween('-30 years', '-3 years'))
                ->setPassword($this->hasher->hashPassword($client, 'password'));

            // Le dernier client est bloqué, (pour tester le UserChecker)
            if ($i === 10) {
                $client->setActif(false);
            }

            $manager->persist($client);

            // On enregistre une référence pour la retrouver dans RendezVousFixtures :
            $this->addReference('client_' . $i, $client);
        }

        $manager->flush();
    }
}