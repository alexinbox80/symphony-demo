<?php

namespace App\Repository;

use App\Entity\Profile;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\Expr\Join;

class UserRepository extends EntityRepository
{
    /**
     * @param int $page
     * @param int $perPage
     * @return User[]
     */
    public function getUsers(int $page, int $perPage): array
    {
//        $qb = $this->getEntityManager()->createQueryBuilder();
//        $qb->select('t')
//            ->from($this->getClassName(), 't')
//            ->orderBy('t.id', 'DESC')
//            ->setFirstResult($perPage * $page)
//            ->setMaxResults($perPage);

//        $qb->select('u', 'p')
//            ->from(User::class, 'u')
//            ->join(Profile::class, 'p', Join::ON, 'u.id = p.user_id');
            //->innerJoin(Profile::class, 'p', Join::ON, 'u.id = p.user_id');
//            ->orderBy('u.id', 'DESC')
//            ->setFirstResult($perPage * $page)
//            ->setMaxResults($perPage);

        $em = $this->getEntityManager();
//https://www.doctrine-project.org/projects/doctrine-orm/en/3.3/reference/dql-doctrine-query-language.html
        $query = $em->createQuery("SELECT u, p FROM App\Entity\User u INNER JOIN App\Entity\Profile p ON u.id = p.user_id");
        $users = $query->getResult();
        dd($users);

        //dd($qb->getQuery()->getArrayResult());

        //dd($qb->getDQL());
        //dd($qb->getQuery()->getResult());

        return $qb->getQuery()->getResult();
    }
}