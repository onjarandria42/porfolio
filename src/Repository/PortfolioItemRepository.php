<?php

namespace App\Repository;

use App\Entity\PortfolioItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortfolioItem>
 */
class PortfolioItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortfolioItem::class);
    }

    /**
     * @return PortfolioItem[] Returns an array of active items ordered by position
     */
    public function findActiveOrdered(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.isActive = :active')
            ->setParameter('active', true)
            ->orderBy('p.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return PortfolioItem[] Returns an array of active items by category
     */
    public function findActiveByCategory(int $categoryId): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.category = :category')
            ->andWhere('p.isActive = :active')
            ->setParameter('category', $categoryId)
            ->setParameter('active', true)
            ->orderBy('p.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
