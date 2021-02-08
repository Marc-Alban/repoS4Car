<?php

namespace App\Repository;

use App\Entity\Car;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

    // /**
    //  * @return Car[] Returns an array of Car objects
    //  */

    public function searchCar($value)
    {
        return $this->createQueryBuilder('c')
            ->where('c.color = :color')
            ->setParameter('color', $value['color'])
            ->andwhere('c.carburant = :carburant')
            ->setParameter('carburant', $value['fuel'])
            ->andwhere('c.price > :minPrice')
            ->setParameter('minPrice', $value['minPrice'])
            ->andwhere('c.price < :maxPrice')
            ->setParameter('maxPrice', $value['maxPrice'])
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Car
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
