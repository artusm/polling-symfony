<?php

namespace App\Repository;

use App\Entity\UserDelete;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserDelete>
 *
 * @method UserDelete|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserDelete|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserDelete[]    findAll()
 * @method UserDelete[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserDeleteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserDelete::class);
    }

    public function add(UserDelete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserDelete $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
