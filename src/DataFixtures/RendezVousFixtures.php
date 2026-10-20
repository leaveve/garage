<?php

namespace App\DataFixtures;

use App\Entity\RendezVous;
use App\Entity\User;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class RendezVousFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct()
    {
        //  Faker en langue française :
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        //une boucle pour créer 15 rendez-vous :
        for ($i = 1; $i <= 15; $i++) {
            $rdv = new RendezVous;

            $motif = $this->faker->randomElement(['achat', 'location', 'essai']);

            // La demande a été envoyée dans les 30 derniers jours
            $dateCreation = $this->faker->dateTimeBetween('-30 days', 'now');
            // Le rendez-vous est prévu dans les 30 prochains jours
            $dateHeure = $this->faker->dateTimeBetween('+1 day', '+30 days');

            $rdv->setClient($this->getReference('client_' . $this->faker->numberBetween(1, 9), User::class))
                ->setVoiture($this->getReference('voiture_' . $this->faker->numberBetween(1, 20), Voiture::class))
                ->setMotif($motif)
                ->setMessage($this->faker->sentence(12))
                ->setStatut($this->faker->randomElement(['en_attente', 'en_attente', 'accepte', 'refuse', 'termine']))
                ->setDateCreation(\DateTimeImmutable::createFromMutable($dateCreation))
                ->setDateHeure(\DateTimeImmutable::createFromMutable($dateHeure));

            // Les dates de location ne sont remplies que si le motif est « location »
            if ($motif === 'location') {
                $debut = $this->faker->dateTimeBetween('+2 days', '+40 days');
                $fin = (clone $debut)->modify('+' . $this->faker->numberBetween(1, 7) . ' days');

                $rdv->setDateDebutLocation(\DateTimeImmutable::createFromMutable($debut))
                    ->setDateFinLocation(\DateTimeImmutable::createFromMutable($fin));
            }

            $manager->persist($rdv);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [UserFixtures::class, VoitureFixtures::class];
    }
}