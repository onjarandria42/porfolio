<?php

namespace App\Repository;

use App\Entity\ContactInfo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactInfo>
 */
class ContactInfoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactInfo::class);
    }

    /**
     * Returns the active contact info
     */
    public function findActive(): ?ContactInfo
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.isActive = :active')
            ->setParameter('active', true)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
