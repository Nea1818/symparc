<?php

namespace App\Repository;

use App\Entity\Parc;
use App\Entity\ParcSearch;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Parc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parc[]    findAll()
 * @method Parc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Parc::class);
    }


    /**
        * @return Query
        */
    public function findAllVisibleQuery(ParcSearch $search)
    {
        $query = $this->findVisibleQuery();

        if ($search->getLat() && $search->getLng() && $search->getDistance()) {
            $query = $query
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  pi()/180 / 2), 2) +COS(p.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance());
        }

        return $query->getQuery();
    }

    /**
     * @return Parc[]
     */
    public function findLatest()
    {
        $properties = $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery();
    }

    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('p');
    }

    // /**
    //  * @return Parc[] Returns an array of Parc objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Parc
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
