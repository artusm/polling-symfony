<?php

namespace App\Repository;

use App\Entity\UserSignupVerificationResend;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserSignupVerificationResend>
 *
 * @method UserSignupVerificationResend|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserSignupVerificationResend|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserSignupVerificationResend[]    findAll()
 * @method UserSignupVerificationResend[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserSignupVerificationResendRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserSignupVerificationResend::class);
    }

    public function add(UserSignupVerificationResend $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(UserSignupVerificationResend $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
