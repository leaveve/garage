<?php

namespace App\DataFixtures;

use App\Entity\Photo;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class PhotoFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        foreach (VoitureFixtures::getVoituresArray() as $index => $data) {
            $voiture = $this->getReference('voiture_' . ($index + 1), Voiture::class);

            foreach ($data['photos'] as $ordre => $nomFichier) {
                $photo = new Photo;
                $photo->setNomFichier($nomFichier)
                    ->setOrdre($ordre + 1);

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
