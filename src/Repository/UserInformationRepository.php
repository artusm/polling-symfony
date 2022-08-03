<?php

namespace App\Repository;

use App\Entity\UserInformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserInformation>
 *
 * @method UserInformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserInformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserInformation[]    findAll()
 * @method UserInformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserInformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserInformation::class);
    }

    public function add(UserInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserInformation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
