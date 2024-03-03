<?php

namespace App\Modules\NavigationMenu\Repository;

use App\Modules\NavigationMenu\Entity\NavigationMenu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NavigationMenu>
 *
 * @method NavigationMenu|null find($id, $lockMode = null, $lockVersion = null)
 * @method NavigationMenu|null findOneBy(array $criteria, array $orderBy = null)
 * @method NavigationMenu[]    findAll()
 * @method NavigationMenu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NavigationMenuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NavigationMenu::class);
    }

}


