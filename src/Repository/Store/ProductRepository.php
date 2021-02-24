<?php

namespace App\Repository\Store;

use App\Entity\Store\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\This;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findLastCreated(): array
    {
        return $this
            ->findBy(
                [],
                ['createdAt' => 'DESC'],
                4,
        );
    }

    public function findMostCommProducts()
    {
        return $this
            ->createQueryBuilder('p')
            ->leftJoin('p.comments', 'c')
            ->orderBy('count(c)', 'DESC')
            ->groupBy('p')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /*public function findAllWithImage(): array {
        $qb = $this->createQueryBuilder('p');

        $this->addImage($qb);

        return $qb->getQuery()->getResult();
    }*/

}
