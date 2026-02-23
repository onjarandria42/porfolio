<?php

namespace App\Repository;

use App\Entity\ResumeItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ResumeItem>
 */
class ResumeItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ResumeItem::class);
    }

    /**
     * @return ResumeItem[] Returns an array of active ResumeItems by type ordered by position
     */
    public function findActiveByTypeOrdered(string $type): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.type = :type')
            ->andWhere('r.isActive = :active')
            ->setParameter('type', $type)
            ->setParameter('active', true)
            ->orderBy('r.position', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ResumeItem[] Returns all active ResumeItems ordered by type and position
     */
    public function findAllActiveOrdered(): array
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.isActive = :active')
            ->setParameter('active', true)
            ->orderBy('r.type', 'ASC')
            ->addOrderBy('r.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
