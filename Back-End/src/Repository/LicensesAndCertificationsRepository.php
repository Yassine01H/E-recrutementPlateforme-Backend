<?php

namespace App\Repository;

use App\Entity\LicensesAndCertifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LicensesAndCertifications>
 *
 * @method LicensesAndCertifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method LicensesAndCertifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method LicensesAndCertifications[]    findAll()
 * @method LicensesAndCertifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LicensesAndCertificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LicensesAndCertifications::class);
    }

    public function save(LicensesAndCertifications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LicensesAndCertifications $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return LicensesAndCertifications[] Returns an array of LicensesAndCertifications objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('l.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?LicensesAndCertifications
//    {
//        return $this->createQueryBuilder('l')
//            ->andWhere('l.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
