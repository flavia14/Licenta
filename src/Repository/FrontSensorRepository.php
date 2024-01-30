<?php

namespace App\Repository;

use App\Dto\RequestDtoSensor;
use App\Entity\FrontSensor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FrontSensor>
 *
 * @method FrontSensor|null find($id, $lockMode = null, $lockVersion = null)
 * @method FrontSensor|null findOneBy(array $criteria, array $orderBy = null)
 * @method FrontSensor[]    findAll()
 * @method FrontSensor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FrontSensorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FrontSensor::class);
    }

    public function save(FrontSensor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FrontSensor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getSensors(string $location, int $limit, RequestDtoSensor $requestDto): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.id', "ASC")
            ->where("f.location = :location")
            ->setFirstResult(($requestDto->getPage() - 1) * $limit)
            ->setMaxResults($limit)
            ->setParameter("location", $location)
            ->orderBy(  $requestDto->getSort(), $requestDto->getOrder())
            ->getQuery()
            ->getResult();
    }

    public function getAllSensors(string $location): array
    {
        return $this->createQueryBuilder('f')
            ->orderBy('f.id', "ASC")
            ->where("f.location = :location")
            ->setParameter("location", $location)
            ->getQuery()
            ->getResult();
    }

    public function getDataSensors(string $location, string $name): array
    {
        $now = new \DateTime('now');
        $fiveMinutesAgo = $now->modify('-1 minutes');
        $fiveMinutesLate = $now->modify('+1 minutes');
        return $this->createQueryBuilder('f')
            ->orderBy('f.id', 'ASC')
            ->where('f.location = :location')
            ->andWhere('f.creationDate > :fiveMinutesAgo AND f.creationDate < :fiveMinutesLate')
            ->setParameter('fiveMinutesAgo', $fiveMinutesAgo)
            ->setParameter('fiveMinutesLate', $fiveMinutesLate)
            ->setParameter('location', $location)
            ->andWhere('f.name = :name')
            ->setParameter('name', $name)
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return FrontSensor[] Returns an array of FrontSensor objects
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

//    public function findOneBySomeField($value): ?FrontSensor
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
