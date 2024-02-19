<?php

namespace App\Modules\NavigationMenu\Repository;

use App\Modules\NavigationMenu\Entity\PageMenuPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageMenuPage>
 *
 * @method PageMenuPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageMenuPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageMenuPage[]    findAll()
 * @method PageMenuPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageMenuPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageMenuPage::class);
    }

}
