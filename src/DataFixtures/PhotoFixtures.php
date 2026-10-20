<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct()
    {
        // On instancie Faker en langue française :
        $this->faker = Factory::create('fr_FR');
    }

    // Les images de démo présentes dans public/uploads/voitures/
    public static function getImagesArray(): array
    {
        return ['demo-1.jpg', 'demo-2.jpg', 'demo-3.jpg', 'demo-4.jpg', 'demo-5.jpg', 'demo-6.jpg'];
    }

    public function load(ObjectManager $manager): void
    {
        // Pour chacune des 20 voitures :
        for ($i = 1; $i <= 20; $i++) {
            $voiture = $this->getReference('voiture_' . $i, Voiture::class);

            // On choisit entre 3 et 5 images différentes
            $images = $this->faker->randomElements(self::getImagesArray(), $this->faker->numberBetween(3, 5));

            // On crée une photo par image, avec un ordre qui commence à 1
            foreach ($images as $index => $nomFichier) {
                $photo = new Photo;
                $photo->setNomFichier($nomFichier)
                    ->setOrdre($index + 1);

                $voiture->addPhoto($photo);
                $manager->persist($photo);
            }
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [VoitureFixtures::class];
    }
}