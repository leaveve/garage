<?php

namespace App\DataFixtures;

use App\Entity\TypeVoiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeVoitureFixtures extends Fixture
{
    public static function getTypesArray(): array
    {
        return ['Sportive', 'Supercar', 'Muscle car', 'JDM', 'GT', 'SUV sportif'];
    }

    public function load(ObjectManager $manager): void
    {
        // Ici, on fait une boucle sur chaque type :
        foreach (self::getTypesArray() as $libelle) {
            $type = new TypeVoiture;
            $type->setLibelle($libelle);

            $manager->persist($type);

            // On enregistre une référence pour la retrouver dans ModeleFixtures :
            $this->addReference('type_' . $libelle, $type);
        }

        $manager->flush();
    }
}