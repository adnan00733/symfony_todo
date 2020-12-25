<?php

namespace App\Repository;

use App\Entity\TodoModel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TodoModel|null find($id, $lockMode = null, $lockVersion = null)
 * @method TodoModel|null findOneBy(array $criteria, array $orderBy = null)
 * @method TodoModel[]    findAll()
 * @method TodoModel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TodoModelRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TodoModel::class);
    }

    // /**
    //  * @return TodoModel[] Returns an array of TodoModel objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TodoModel
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
