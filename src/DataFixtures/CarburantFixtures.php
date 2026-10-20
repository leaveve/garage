<?php

namespace App\DataFixtures;

use App\Entity\Carburant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarburantFixtures extends Fixture
{
    public static function getCarburantsArray(): array
    {
        return ['Essence', 'Diesel', 'Hybride'];
    }

    public function load(ObjectManager $manager): void
    {
        // Ici, on fait une boucle sur chaque carburant :
        foreach (self::getCarburantsArray() as $libelle) {
            $carburant = new Carburant;
            $carburant->setLibelle($libelle);

            $manager->persist($carburant);

            // On enregistre une référence pour la retrouver dans ModeleFixtures :
            $this->addReference('carburant_' . $libelle, $carburant);
        }

        $manager->flush();
    }
}