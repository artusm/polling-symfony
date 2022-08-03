<?php

namespace App\Repository;

use App\Entity\UserEmailNew;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserEmailNew>
 *
 * @method UserEmailNew|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserEmailNew|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserEmailNew[]    findAll()
 * @method UserEmailNew[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserEmailNewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserEmailNew::class);
    }

    public function add(UserEmailNew $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserEmailNew $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
