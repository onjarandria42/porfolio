<?php

namespace App\Repository;

use App\Entity\PortfolioCategory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortfolioCategory>
 */
class PortfolioCategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioCategory::class);
    }

    /**
     * @return PortfolioCategory[] Returns an array of active categories ordered by position
     */
    public function findActiveOrdered(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.isActive = :active')
            ->setParameter('active', true)
            ->orderBy('c.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
