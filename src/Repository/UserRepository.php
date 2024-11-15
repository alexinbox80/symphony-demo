<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param int $page
     * @param int $perPage
     * @return User[]
     */
    public function getUsers(int $page, int $perPage): array
    {
        $qb = $this->getEntityManager()->createQueryBuilder();
        $qb->select('u')
            ->from($this->getClassName(), 'u')
            ->orderBy('u.id', 'DESC')
            ->setFirstResult($perPage * $page)
            ->setMaxResults($perPage);

        //dd($this->findAll());

        return $qb->getQuery()->getResult();
    }
}
