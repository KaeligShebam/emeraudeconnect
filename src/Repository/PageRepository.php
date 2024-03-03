<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\DBAL\ParameterType;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Psr\Log\LoggerInterface;
use Doctrine\ORM\EntityManagerInterface;

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
    private readonly LoggerInterface $logger;

    public function __construct(EntityManagerInterface $entityManager, LoggerInterface $logger, ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
        $this->logger = $logger;
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

    public function findPagesNotInMenu(int $menuId): array
    {
        return $this->createQueryBuilder('p')
            ->leftJoin('App\Modules\NavigationMenu\Entity\PageMenuPage', 'pmp', 'WITH', 'pmp.page = p.id')
            ->andWhere('pmp.navigationMenu != :menuId OR pmp.navigationMenu IS NULL')
            ->setParameter('menuId', $menuId)
            ->getQuery()
            ->getResult();
    }

    public function findPagesInMenu(int $menuId): array
    {
        return $this->createQueryBuilder('p')
            ->join('App\Modules\NavigationMenu\Entity\PageMenuPage', 'pmp', 'WITH', 'pmp.page = p.id')
            ->andWhere('pmp.navigationMenu = :menuId')
            ->setParameter('menuId', $menuId)
            ->orderBy('pmp.position', 'ASC') // Ordonner par position croissante
            ->getQuery()
            ->getResult();
    }
    

}
