<?php

namespace App\DataFixtures;

use App\Entity\Carburant;
use App\Entity\Modele;
use App\Entity\Transmission;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class VoitureFixtures extends Fixture implements DependentFixtureInterface
{
    public static function getVoituresArray(): array
    {
        return [
            [
                'modele' => 'Challenger SRT Hellcat',
                'transmission' => 'Manuelle',
                'carburant' => 'Diesel',
                'annee' => 2009,
                'kilometrage' => 980,
                'puissanceCh' => 434,
                'couleur' => 'Blanc Nacré',
                'couleurHex' => '#f4f4f0',
                'prixVente' => 78363,
                'prixLocationJour' => null,
                'caution' => null,
                'description' => 'Eius accusamus ut repellendus quo. Ea minus sit laboriosam ut. Suscipit ducimus consectetur et consequatur et libero. Ea maxime nostrum ut magnam libero eos.',
                'aVendre' => true,
                'aLouer' => false,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae782541bd2b.png',
                    'voiture-6ae783d1bae8e.png',
                    'voiture-6ae783d1bb07e.png',
                    'voiture-6ae783e714c26.png',
                    'voiture-6ae7840662d6d.png',
                ],
            ],
            [
                'modele' => 'Viper',
                'transmission' => 'Séquentielle',
                'carburant' => 'Hybride',
                'annee' => 2025,
                'kilometrage' => 108669,
                'puissanceCh' => 569,
                'couleur' => 'Gris Nardo',
                'couleurHex' => '#7d7f7d',
                'prixVente' => 1234567,
                'prixLocationJour' => 2457,
                'caution' => 6678,
                'description' => 'Vitae qui voluptatem quo eos. Iusto est voluptates excepturi. Mollitia porro incidunt sint in optio veniam non. Asperiores quod enim nesciunt facilis repellendus voluptates. Molestiae aspernatur beatae laborum qui voluptatibus non.',
                'aVendre' => false,
                'aLouer' => true,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae78a90c4d93.png',
                    'voiture-6ae7894786893.png',
                    'voiture-6ae7896259a4b.png',
                    'voiture-6ae7898d0cae4.png',
                ],
            ],
            [
                'modele' => 'M8 Gran Coupé',
                'transmission' => 'Double embrayage',
                'carburant' => 'Essence',
                'annee' => 2007,
                'kilometrage' => 3944,
                'puissanceCh' => 731,
                'couleur' => 'burgundy',
                'couleurHex' => '#450011',
                'prixVente' => 113392,
                'prixLocationJour' => null,
                'caution' => null,
                'description' => 'Eos ut sed aut omnis non  Consectetur aut aut magnam quo.',
                'aVendre' => true,
                'aLouer' => false,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae78e323e705.png',
                    'voiture-6ae78e323eb1b.png',
                    'voiture-6ae78e323ee84.png',
                    'voiture-6ae78e323f0d4.png',
                ],
            ],
            [
                'modele' => '911 GT3',
                'transmission' => 'Double embrayage',
                'carburant' => 'Diesel',
                'annee' => 1999,
                'kilometrage' => 49709,
                'puissanceCh' => 347,
                'couleur' => 'Noir Obsidienne',
                'couleurHex' => '#0b0b0b',
                'prixVente' => 206456,
                'prixLocationJour' => null,
                'caution' => null,
                'description' => 'Ratione qui quas quidem harum quod enim tenetur. Perferendis quia molestias nesciunt expedita fugiat. Mollitia blanditiis sapiente ut tenetur aspernatur mollitia quam. Iusto exercitationem dignissimos illum.',
                'aVendre' => true,
                'aLouer' => false,
                'statut' => 'louee',
                'photos' => [
                    'voiture-6ae7911ba782f.png',
                    'voiture-6ae7911ba7ba1.png',
                    'voiture-6ae7911ba7d8f.png',
                    'voiture-6ae7911ba7f4f.png',
                ],
            ],
            [
                'modele' => 'Lancer Evolution X',
                'transmission' => 'Séquentielle',
                'carburant' => 'Essence',
                'annee' => 2008,
                'kilometrage' => 37265,
                'puissanceCh' => 469,
                'couleur' => 'Vert Verde Mantis',
                'couleurHex' => '#6DBE2E',
                'prixVente' => 312571,
                'prixLocationJour' => 626,
                'caution' => 18395,
                'description' => 'Fugit ut hic ut quo est. Architecto sunt quas quibusdam sunt.',
                'aVendre' => true,
                'aLouer' => true,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae7930bb1693.png',
                    'voiture-6ae79325c5656.png',
                    'voiture-6ae793380ae95.png',
                ],
            ],
            [
                'modele' => 'Skyline R34',
                'transmission' => 'Double embrayage',
                'carburant' => 'Essence',
                'annee' => 2012,
                'kilometrage' => 66125,
                'puissanceCh' => 440,
                'couleur' => 'Vert Pomme',
                'couleurHex' => '#6DD100',
                'prixVente' => 227689,
                'prixLocationJour' => 1240,
                'caution' => 14113,
                'description' => 'minus deleniti sequi ut.',
                'aVendre' => true,
                'aLouer' => true,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae79564ad816.png',
                    'voiture-6ae7956d8d9c7.png',
                    'voiture-6ae79580b57f7.png',
                    'voiture-6ae7967655f9d.png',
                ],
            ],
            [
                'modele' => 'Huracán',
                'transmission' => 'Séquentielle',
                'carburant' => 'Hybride',
                'annee' => 2025,
                'kilometrage' => 18441,
                'puissanceCh' => 425,
                'couleur' => 'Rosso Corsa',
                'couleurHex' => '#D40000',
                'prixVente' => null,
                'prixLocationJour' => 1657,
                'caution' => 6428,
                'description' => 'Eos corrupti eos cupiditate sint mollitia consequatur debitis iste. Et deleniti a distinctio non perspiciatis aut. Dolorem labore ut repellat id non reprehenderit. Alias veniam aut sunt quis.',
                'aVendre' => false,
                'aLouer' => true,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae7980254504.png',
                    'voiture-6ae798025491d.png',
                    'voiture-6ae7980254b4c.png',
                    'voiture-6ae7980254d75.png',
                ],
            ],
            [
                'modele' => 'Urus',
                'transmission' => 'Séquentielle',
                'carburant' => 'Diesel',
                'annee' => 2025,
                'kilometrage' => 92554,
                'puissanceCh' => 683,
                'couleur' => 'Rose Gold',
                'couleurHex' => '#E7B6B9',
                'prixVente' => 241234,
                'prixLocationJour' => 2059,
                'caution' => 6238,
                'description' => 'Dolorem voluptatibus non quisquam qui in est. Magnam saepe rerum molestiae corrupti consequuntur autem. Modi necessitatibus nisi repellendus magni earum voluptate.',
                'aVendre' => false,
                'aLouer' => true,
                'statut' => 'louee',
                'photos' => [
                    'voiture-6ae79a87180bd.png',
                    'voiture-6ae79a871843f.png',
                    'voiture-6ae79a8718614.png',
                    'voiture-6ae79a8718845.png',
                ],
            ],
            [
                'modele' => 'Supra MK4',
                'transmission' => 'Automatique',
                'carburant' => 'Diesel',
                'annee' => 2001,
                'kilometrage' => 45952,
                'puissanceCh' => 359,
                'couleur' => 'Jaune Pomme',
                'couleurHex' => '#FFFF00',
                'prixVente' => null,
                'prixLocationJour' => 574,
                'caution' => 12406,
                'description' => 'Quaerat ipsum consequatur sed natus fugiat asperiores aperiam consequatur. Architecto et voluptas quos sit dolorem ut est. Sit mollitia debitis voluptatum ut aliquid sed.',
                'aVendre' => false,
                'aLouer' => true,
                'statut' => 'louee',
                'photos' => [
                    'voiture-6ae79d31b6b7a.png',
                    'voiture-6ae79d31b6fbb.png',
                    'voiture-6ae79d31b71d5.png',
                    'voiture-6ae79d31b7411.png',
                ],
            ],
            [
                'modele' => 'Roma',
                'transmission' => 'Séquentielle',
                'carburant' => 'Diesel',
                'annee' => 2014,
                'kilometrage' => 2432,
                'puissanceCh' => 734,
                'couleur' => 'Jaune Giallo',
                'couleurHex' => '#F6C700',
                'prixVente' => 94314,
                'prixLocationJour' => 1316,
                'caution' => 26591,
                'description' => 'Mollitia voluptates consectetur quidem fugiat iure assumenda sed. Tempore rerum quae eaque mollitia rerum quas. Qui in debitis velit quisquam quibusdam ipsum rem. Maxime velit totam sint error voluptatem qui.',
                'aVendre' => true,
                'aLouer' => true,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae79f201ab11.png',
                    'voiture-6ae79f201ae87.png',
                    'voiture-6ae79f201b0c0.png',
                    'voiture-6ae79f201b2dc.png',
                ],
            ],
            [
                'modele' => 'GT-R R35',
                'transmission' => 'Séquentielle',
                'carburant' => 'Diesel',
                'annee' => 2010,
                'kilometrage' => 28776,
                'puissanceCh' => 428,
                'couleur' => 'Silvery Blue',
                'couleurHex' => '#5D88BB',
                'prixVente' => 253722,
                'prixLocationJour' => null,
                'caution' => null,
                'description' => 'Corporis quia omnis vel id odit atque cupiditate nihil. At dolor perspiciatis aut at et. Vel dolorem et officia quo. Et eius quia voluptatem quas error aut aperiam.',
                'aVendre' => true,
                'aLouer' => false,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae7a0cf86bf2.png',
                    'voiture-6ae7a0cf87069.png',
                    'voiture-6ae7a0cf872a1.png',
                    'voiture-6ae7a0cf874c9.png',
                ],
            ],
            [
                'modele' => 'Lancer Evolution IX',
                'transmission' => 'Manuelle',
                'carburant' => 'Essence',
                'annee' => 2018,
                'kilometrage' => 64267,
                'puissanceCh' => 699,
                'couleur' => 'Royal Blue',
                'couleurHex' => '#000080',
                'prixVente' => null,
                'prixLocationJour' => 710,
                'caution' => 23549,
                'description' => 'Qui numquam molestiae aspernatur. Facilis et numquam aperiam consequuntur. Adipisci aliquam numquam quae est labore vel vero eum.',
                'aVendre' => false,
                'aLouer' => true,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae7a1d3221cb.png',
                    'voiture-6ae7a1d322556.png',
                    'voiture-6ae7a1d322856.png',
                    'voiture-6ae7a1d322abb.png',
                ],
            ],
            [
                'modele' => 'M3 Competition',
                'transmission' => 'Automatique',
                'carburant' => 'Diesel',
                'annee' => 2019,
                'kilometrage' => 109178,
                'puissanceCh' => 430,
                'couleur' => 'Royal Purple',
                'couleurHex' => '#6C3BAA',
                'prixVente' => 95922,
                'prixLocationJour' => null,
                'caution' => null,
                'description' => 'Dolor quasi commodi ipsam dolorem molestias nisi voluptatem enim. Alias et fuga eos minus nihil. Et amet quis est iste voluptatem est corrupti. Ipsam alias voluptate ratione totam est eum ipsa.',
                'aVendre' => true,
                'aLouer' => false,
                'statut' => 'disponible',
                'photos' => [
                    'voiture-6ae7a30d9978c.png',
                    'voiture-6ae7a30d99a5e.png',
                    'voiture-6ae7a30d99ca5.png',
                    'voiture-6ae7a30d99ec3.png',
                ],
            ],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::getVoituresArray() as $index => $data) {
            $voiture = new Voiture;

            $voiture->setModele($this->getReference('modele_' . $data['modele'], Modele::class))
                ->setTransmission($this->getReference('transmission_' . $data['transmission'], Transmission::class))
                ->setCarburant($this->getReference('carburant_' . $data['carburant'], Carburant::class))
                ->setAnnee($data['annee'])
                ->setKilometrage($data['kilometrage'])
                ->setPuissanceCh($data['puissanceCh'])
                ->setCouleur($data['couleur'])
                ->setCouleurHex($data['couleurHex'])
                ->setDescription($data['description'])
                ->setAVendre($data['aVendre'])
                ->setALouer($data['aLouer'])
                ->setPrixVente($data['prixVente'])
                ->setPrixLocationJour($data['prixLocationJour'])
                ->setCaution($data['caution'])
                ->setStatut($data['statut']);

            $manager->persist($voiture);

            $this->addReference('voiture_' . ($index + 1), $voiture);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ModeleFixtures::class, TransmissionFixtures::class, CarburantFixtures::class];
    }
}
