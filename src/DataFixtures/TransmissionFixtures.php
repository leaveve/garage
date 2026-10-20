<?php

namespace App\DataFixtures;

use App\Entity\Transmission;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TransmissionFixtures extends Fixture
{
    public static function getTransmissionsArray(): array
    {
        return ['Manuelle', 'Automatique', 'Séquentielle', 'Double embrayage'];
    }

    public function load(ObjectManager $manager): void
    {
        // Ici, on fait une boucle sur chaque transmission :
        foreach (self::getTransmissionsArray() as $libelle) {
            $transmission = new Transmission;
            $transmission->setLibelle($libelle);

            $manager->persist($transmission);

            // On enregistre une référence pour la retrouver dans ModeleFixtures :
            $this->addReference('transmission_' . $libelle, $transmission);
        }

        $manager->flush();
    }
}