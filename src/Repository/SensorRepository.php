<?php

namespace App\Repository;

use App\Dto\RequestDtoSensor;
use App\Entity\Sensor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Sensor>
 *
 * @method Sensor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sensor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sensor[]    findAll()
 * @method Sensor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SensorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sensor::class);
    }

    public function save(Sensor $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Sensor $entity, bool $flush = false): void
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
        $now = new \DateTime('now');
        $twoMinutesAgo = clone $now;
        $twoMinutesAgo->modify('-1 minute');
        $twoMinutesLate = clone $now;
        $twoMinutesLate->modify('+1 minute');

        return $this->createQueryBuilder('f')
            ->orderBy('f.id', 'ASC')
            ->where('f.location = :location')
            ->andWhere('f.creationDate > :twoMinutesAgo')
            ->andWhere('f.creationDate < :twoMinutesLate')
            ->setParameters([
                'location' => $location,
                'twoMinutesAgo' => $twoMinutesAgo,
                'twoMinutesLate' => $twoMinutesLate,
            ])
            ->getQuery()
            ->getResult();
    }

    public function getDataSensors(string $location, string $name): array
    {
        $now = new \DateTime('now');
        $fiveMinutesAgo = clone $now;
        $fiveMinutesAgo->modify('-1 minute');
        $fiveMinutesLate = clone $now;
        $fiveMinutesLate->modify('+1 minute');

        return $this->createQueryBuilder('f')
            ->orderBy('f.id', 'ASC')
            ->where('f.location = :location')
            ->andWhere('f.creationDate > :fiveMinutesAgo')
            ->andWhere('f.creationDate < :fiveMinutesLate')
            ->andWhere('f.name = :name')
            ->setParameters([
                'location' => $location,
                'fiveMinutesAgo' => $fiveMinutesAgo,
                'fiveMinutesLate' => $fiveMinutesLate,
                'name' => $name,
            ])
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return Sensor[] Returns an array of Sensor objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Sensor
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
