<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MarqueFixtures extends Fixture
{
    public static function getMarquesArray(): array
    {
        return ['Mitsubishi', 'Dodge', 'Nissan', 'Porsche', 'Ferrari', 'Lamborghini', 'Toyota', 'BMW'];
    }

    public function load(ObjectManager $manager): void
    {
        // Ici, on fait une boucle sur chaque marque :
        foreach (self::getMarquesArray() as $libelle) {
            $marque = new Marque;
            $marque->setLibelle($libelle);

            $manager->persist($marque);

            // On enregistre une référence pour la retrouver dans ModeleFixtures :
            $this->addReference('marque_' . $libelle, $marque);
        }

        $manager->flush();
    }
}