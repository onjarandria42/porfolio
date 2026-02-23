<?php

namespace App\Repository;

use App\Entity\ContactMessage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ContactMessage>
 */
class ContactMessageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ContactMessage::class);
    }

    /**
     * @return ContactMessage[] Returns an array of messages ordered by creation date
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return ContactMessage[] Returns an array of new messages
     */
    public function findNewMessages(): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.status = :status')
            ->setParameter('status', ContactMessage::STATUS_NEW)
            ->orderBy('c.createdAt', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns the count of new messages
     */
    public function countNewMessages(): int
    {
        return $this->createQueryBuilder('c')
            ->select('COUNT(c.id)')
            ->andWhere('c.status = :status')
            ->setParameter('status', ContactMessage::STATUS_NEW)
            ->getQuery()
            ->getSingleScalarResult();
    }
}
