<?php

namespace App\Repository;

use App\Entity\Stat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stat>
 */
class StatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stat::class);
    }

    /**
     * @return Stat[] Returns an array of active Stats ordered by position
     */
    public function findActiveOrdered(): array
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.isActive = :active')
            ->setParameter('active', true)
            ->orderBy('s.position', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
