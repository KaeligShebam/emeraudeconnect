<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Page>
 *
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    public function findActivePages(): array
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->andWhere('p.isDeleted = :isDeleted')
            ->setParameter('isDeleted', 0)
            ->orWhere('p.isDeleted IS NULL')
            ->getQuery()
            ->getResult();
    }
    public function findForSitemap()
    {
        return $this->createQueryBuilder('p')
        ->join('p.seo', 's')
        ->join('p.status', 'ps')
        ->andWhere('s.indexation = :indexation')
        ->andWhere('ps.name = :status')
        ->setParameter('indexation', 1) // Remplacez par la valeur que vous souhaitez
        ->setParameter('status', 'Publié') // Remplacez 'Publié' par la valeur correcte
        ->getQuery()
        ->getResult();
    }
}
