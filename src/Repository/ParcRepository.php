<?php

namespace App\Repository;

use App\Entity\Parc;
use App\Entity\Picture;
use App\Entity\ParcSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Parc|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parc|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parc[]    findAll()
 * @method Parc[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcRepository extends ServiceEntityRepository
{
    /**
    * @var PaginatorInterface
    */
    private $paginator;

    public function __construct(RegistryInterface $registry, PaginatorInterface $paginator)
    {
        parent::__construct($registry, Parc::class);
        $this->paginator = $paginator;
    }

    /**
     * @return PaginationInterface
     */
    public function paginateAllVisible(ParcSearch $search, int $page): PaginationInterface
    {
        $query = $this->findVisibleQuery();

        if ($search->getLat() && $search->getLng() && $search->getDistance()) {
            $query = $query
                ->andWhere('(6353 * 2 * ASIN(SQRT( POWER(SIN((p.lat - :lat) *  pi()/180 / 2), 2) +COS(p.lat * pi()/180) * COS(:lat * pi()/180) * POWER(SIN((p.lng - :lng) * pi()/180 / 2), 2) ))) <= :distance')
                ->setParameter('lng', $search->getLng())
                ->setParameter('lat', $search->getLat())
                ->setParameter('distance', $search->getDistance());
        }

        $parcs = $this->paginator->paginate(
            $query->getQuery(),
            $page,
            4
        );


        $this->hydratePicture($parcs);

        return $parcs;
    }

    /**
    * @return Parc[]
    */
    public function findLatest(): array
    {
        $parcs = $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
        $this->hydratePicture($parcs);
        return $parcs;
    }

    private function findVisibleQuery()
    {
        return $this->createQueryBuilder('p');
    }


    private function hydratePicture($parcs)
    {
        if (method_exists($parcs, 'getItems')) {
            $parcs = $parcs->getItems();
        }
        $pictures = $this->getEntityManager()->getRepository(Picture::class)->findForParcs($parcs);
        foreach ($parcs as $parc) {
            /** @var $parc Parc */
            if ($pictures->containsKey($parc->getId())) {
                $parc->setPicture($pictures->get($parc->getId()));
            }
        }
    }
}
