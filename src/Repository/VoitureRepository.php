<?php

namespace App\Repository;

use App\Entity\Voiture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Voiture>
 */
class VoitureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Voiture::class);
    }

    public function findCatalogue(array $filtres): array
    {
        $qb = $this->createQueryBuilder('v')
            ->join('v.modele', 'mo')
            ->join('mo.marque', 'ma')
            ->join('mo.typeVoiture', 't')
            ->where('v.statut = :statut')
            ->setParameter('statut', 'disponible');

        if (!empty($filtres['marque'])) {
            $qb->andWhere('ma.id = :marque')
                ->setParameter('marque', $filtres['marque']);
        }

        if (!empty($filtres['type'])) {
            $qb->andWhere('t.id = :type')
                ->setParameter('type', $filtres['type']);
        }

        $mode = $filtres['mode'] ?? '';
        if ($mode === 'vente') {
            $qb->andWhere('v.aVendre = true');
        } elseif ($mode === 'location') {
            $qb->andWhere('v.aLouer = true');
        }

        $champPrix = $mode === 'location' ? 'v.prixLocationJour' : 'v.prixVente';

        switch ($filtres['tri'] ?? '') {
            case 'prix_asc':
                $qb->addSelect("CASE WHEN $champPrix IS NULL THEN 1 ELSE 0 END AS HIDDEN sansPrix")
                    ->orderBy('sansPrix', 'ASC')
                    ->addOrderBy($champPrix, 'ASC');
                break;
            case 'prix_desc':
                $qb->addSelect("CASE WHEN $champPrix IS NULL THEN 1 ELSE 0 END AS HIDDEN sansPrix")
                    ->orderBy('sansPrix', 'ASC')
                    ->addOrderBy($champPrix, 'DESC');
                break;
            case 'puissance':
                $qb->orderBy('v.puissanceCh', 'DESC');
                break;
            default:
                $qb->orderBy('v.annee', 'DESC');
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Voiture[] Returns an array of Voiture objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Voiture
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
