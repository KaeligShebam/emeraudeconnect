<?php

namespace App\Repository;

use App\Entity\PageMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageMenu>
 *
 * @method PageMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageMenu[]    findAll()
 * @method PageMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageMenu::class);
    }

//    /**
//     * @return PageMenu[] Returns an array of PageMenu objects
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

//    public function findOneBySomeField($value): ?PageMenu
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
