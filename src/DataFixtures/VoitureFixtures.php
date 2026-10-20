<?php

namespace App\DataFixtures;

use App\Entity\Carburant;
use App\Entity\Modele;
use App\Entity\Transmission;
use App\Entity\Voiture;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class VoitureFixtures extends Fixture implements DependentFixtureInterface
{
    protected $faker;

    public function __construct()
    {
        // Faker en langue française :
        $this->faker = Factory::create('fr_FR');
    }

    // Couleurs de voitures de sport avec leur code hexadécimal
    public static function getCouleursArray(): array
    {
        return [
            ['nom' => 'Rosso Corsa',      'hex' => '#D40000'],
            ['nom' => 'Noir Obsidienne',  'hex' => '#0B0B0B'],
            ['nom' => 'Blanc Nacré',      'hex' => '#F4F4F0'],
            ['nom' => 'Gris Nardo',       'hex' => '#7D7F7D'],
            ['nom' => 'Bleu Bayside',     'hex' => '#1C4E9C'],
            ['nom' => 'Plum Crazy',       'hex' => '#5B2A86'],
            ['nom' => 'Vert Verde Mantis','hex' => '#6DBE2E'],
            ['nom' => 'Jaune Giallo',     'hex' => '#F6C700'],
        ];
    }

    public function load(ObjectManager $manager): void
    {
        //une boucle pour créer 20 voitures :
        for ($i = 1; $i <= 20; $i++) {
            $voiture = new Voiture;

            // Le modèle, la transmission et le carburant, pris au hasard dans les listes
            $modele = $this->faker->randomElement(ModeleFixtures::getModelesArray());
            $transmission = $this->faker->randomElement(TransmissionFixtures::getTransmissionsArray());
            $carburant = $this->faker->randomElement(CarburantFixtures::getCarburantsArray());
            $couleur = $this->faker->randomElement(self::getCouleursArray());

            // À vendre, à louer, ou les deux (jamais aucun des deux au départ)
            $aVendre = $this->faker->boolean(70);
            $aLouer = $aVendre ? $this->faker->boolean(50) : true;

            $voiture->setModele($this->getReference('modele_' . $modele['libelle'], Modele::class))
                ->setTransmission($this->getReference('transmission_' . $transmission, Transmission::class))
                ->setCarburant($this->getReference('carburant_' . $carburant, Carburant::class))
                ->setAnnee($this->faker->numberBetween(1998, 2025))
                ->setKilometrage($this->faker->numberBetween(500, 120000))
                ->setPuissanceCh($this->faker->numberBetween(280, 800))
                ->setCouleur($couleur['nom'])
                ->setCouleurHex($couleur['hex'])
                ->setDescription($this->faker->paragraph(3))
                ->setAVendre($aVendre)
                ->setALouer($aLouer)
                // Les prix ne sont remplis que si la voiture est à vendre / à louer
                ->setPrixVente($aVendre ? $this->faker->numberBetween(45000, 350000) : null)
                ->setPrixLocationJour($aLouer ? $this->faker->numberBetween(300, 2500) : null)
                ->setCaution($aLouer ? $this->faker->numberBetween(5000, 30000) : null)
                // La plupart des voitures sont disponibles
                ->setStatut($this->faker->randomElement(['disponible', 'disponible', 'disponible', 'louee', 'vendue']));

            $manager->persist($voiture);

            //  une référence pour la retrouver dans RendezVousFixtures :
            $this->addReference('voiture_' . $i, $voiture);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [ModeleFixtures::class, TransmissionFixtures::class, CarburantFixtures::class];
    }
}