<?php

namespace App\Repository;

use App\Entity\Sortie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Sortie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sortie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sortie[]    findAll()
 * @method Sortie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortieRepository extends ServiceEntityRepository
{
    public function findByNomApproximatif($nom)
    {
        $queryBuider = $this->createQueryBuilder('s');
        $queryBuider->where('s.nom LIKE :nom')
            ->setParameter('nom', '%' . $nom . '%');

        return $queryBuider->getQuery()->getResult();
    }

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sortie::class);
    }

    /**
     * @return Sortie[] Returns an array of Sortie objects
     */
    public function findByCriterion($dateDebut = null, $dateFin = null, $nomRecherche = null, $siteRecherche = null, $isInscrit,/*$isNotInscrit*/ $user, $etatPasse, $isOrganisateur)
    {
        $qb = $this->createQueryBuilder('s');
        if ($dateDebut) {
            $qb
                ->andWhere('s.dateHeureDebut >= :dateDebut')
                ->setParameter('dateDebut', $dateDebut);
        }
        if ($dateFin) {
            $qb
                ->andWhere('s.dateLimiteInscription <= :dateFin')
                ->setParameter('dateFin', $dateFin);
        }
        if ($nomRecherche) {
            $qb
                ->andWhere('s.nom = :nomRecherche')
                ->setParameter('nomRecherche', $nomRecherche);
        }  if ($siteRecherche) {
            $qb
                ->andWhere('s.sites = :siteRecherche')
                ->setParameter('siteRecherche', $siteRecherche);
        } if ($isInscrit) {
        $qb
            ->join('s.idInscr', 'i')
            ->andWhere('i.id_participant = :user')
            ->setParameter('user', $user);

        }  if ($etatPasse) {
        $qb
            ->andWhere('s.etat = :etatPasse')
            ->setParameter('etatPasse', $etatPasse);
    } if ($isOrganisateur) {
        $qb
            ->join('s.idInscr', 'i')
            ->andWhere('i.id_participant = :user')
            ->setParameter('user', $user);

//        } if ($isNotInscrit) {
//        $qb
//            ->join('s.idInscr', 'i')
//            ->andWhere('i.id_participant != :user')
//            ->setParameter('user', $user);
    }
        return $qb->getQuery()->getResult();
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
    }

    /*
    public function findOneBySomeField($value): ?Sortie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
