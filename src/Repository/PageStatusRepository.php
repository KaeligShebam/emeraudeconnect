<?php

namespace App\Repository;

use App\Entity\PageStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageStatus>
 *
 * @method PageStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageStatus[]    findAll()
 * @method PageStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageStatus::class);
    }

//    /**
//     * @return PageStatus[] Returns an array of PageStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PageStatus
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
