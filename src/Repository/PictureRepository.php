<?php

namespace App\Repository;

use App\Entity\Picture;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    /**
     * @param Parc[] $parcs
     * @return ArrayCollection
     */
    public function findForParcs(array $parcs): ArrayCollection
    {
        $qb = $this->createQueryBuilder('p');
        $pictures = $qb
            ->select('p')
            ->where(
                $qb->expr()->in(
                    'p.id',
                    $this->createQueryBuilder('p2')
                        ->select('MIN(p2.id)')
                        ->where('p2.parc IN (:parcs)')
                        ->groupBy('p2.parc')
                        ->getDQL()
                )
            )
            ->getQuery()
            ->setParameter('parcs', $parcs)
            ->getResult();
        $pictures = array_reduce($pictures, function (array $acc, Picture $picture) {
            $acc[$picture->getParc()->getId()] = $picture;
            return $acc;
        }, []);
        return new ArrayCollection($pictures);
    }
}
