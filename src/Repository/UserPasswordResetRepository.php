<?php

namespace App\Repository;

use App\Entity\UserPasswordReset;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserPasswordReset>
 *
 * @method UserPasswordReset|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserPasswordReset|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserPasswordReset[]    findAll()
 * @method UserPasswordReset[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserPasswordResetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserPasswordReset::class);
    }

    public function add(UserPasswordReset $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserPasswordReset $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
