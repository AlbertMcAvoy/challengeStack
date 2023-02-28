<?php

namespace App\Repository;

use App\Entity\FoodSubSubGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FoodSubSubGroup>
 *
 * @method FoodSubSubGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method FoodSubSubGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method FoodSubSubGroup[]    findAll()
 * @method FoodSubSubGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FoodSubSubGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FoodSubSubGroup::class);
    }

    public function save(FoodSubSubGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FoodSubSubGroup $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return FoodSubSubGroup[] Returns an array of FoodSubSubGroup objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?FoodSubSubGroup
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
