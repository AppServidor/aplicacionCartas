<?php

namespace App\Repository;

use App\Entity\Cartas;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Cartas[]    busquedaAjax($letras)
 * @method Cartas|null find($id, $lockMode = null, $lockVersion = null)
 * @method Cartas|null findOneBy(array $criteria, array $orderBy = null)
 * @method Cartas[]    findAll()
 * @method Cartas[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartasRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Cartas::class);
    }


    public function busquedaAjax($letras)
    {
        return $this->createQueryBuilder('a')
        ->andWhere('a.nombre LIKE :val')
        ->setParameter('val','%'.$letras.'%') 
         ->getQuery()
         ->getResult()
         ;
    }

    // /**
    //  * @return Cartas[] Returns an array of Cartas objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Cartas
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
