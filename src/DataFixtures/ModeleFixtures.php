<?php

namespace App\DataFixtures;

use App\Entity\Marque;
use App\Entity\Modele;
use App\Entity\TypeVoiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ModeleFixtures extends Fixture implements DependentFixtureInterface
{
    // Chaque modèle avec sa marque et son type
    public static function getModelesArray(): array
    {
        return [
            ['libelle' => 'Lancer Evolution IX', 'marque' => 'Mitsubishi',  'type' => 'JDM'],
            ['libelle' => 'Lancer Evolution X',  'marque' => 'Mitsubishi',  'type' => 'JDM'],
            ['libelle' => 'Challenger SRT Hellcat', 'marque' => 'Dodge',    'type' => 'Muscle car'],
            ['libelle' => 'Charger SRT',         'marque' => 'Dodge',       'type' => 'Muscle car'],
            ['libelle' => 'Viper',               'marque' => 'Dodge',       'type' => 'Supercar'],
            ['libelle' => 'GT-R R35',            'marque' => 'Nissan',      'type' => 'JDM'],
            ['libelle' => 'Skyline R34',         'marque' => 'Nissan',      'type' => 'JDM'],
            ['libelle' => '911 GT3',             'marque' => 'Porsche',     'type' => 'Sportive'],
            ['libelle' => 'Cayenne Turbo',       'marque' => 'Porsche',     'type' => 'SUV sportif'],
            ['libelle' => 'F8 Tributo',          'marque' => 'Ferrari',     'type' => 'Supercar'],
            ['libelle' => 'Roma',                'marque' => 'Ferrari',     'type' => 'GT'],
            ['libelle' => 'Huracán',             'marque' => 'Lamborghini', 'type' => 'Supercar'],
            ['libelle' => 'Urus',                'marque' => 'Lamborghini', 'type' => 'SUV sportif'],
            ['libelle' => 'Supra MK4',           'marque' => 'Toyota',      'type' => 'JDM'],
            ['libelle' => 'M3 Competition',      'marque' => 'BMW',         'type' => 'Sportive'],
            ['libelle' => 'M8 Gran Coupé',       'marque' => 'BMW',         'type' => 'GT'],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        // une boucle sur chaque modèle :
        foreach (self::getModelesArray() as $data) {
            $modele = new Modele;
            $modele->setLibelle($data['libelle'])
                ->setMarque($this->getReference('marque_' . $data['marque'], Marque::class))
                ->setTypeVoiture($this->getReference('type_' . $data['type'], TypeVoiture::class));

            $manager->persist($modele);

            // enregistre une référence pour la retrouver dans VoitureFixtures :
            $this->addReference('modele_' . $data['libelle'], $modele);
        }

        $manager->flush();
    }

    // Les marques et les types doivent être créés avant les modèles
    public function getDependencies(): array
    {
        return [MarqueFixtures::class, TypeVoitureFixtures::class];
    }
}