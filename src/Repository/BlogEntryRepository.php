<?php

namespace App\Repository;

use App\Entity\BlogEntry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\ORMException;
use phpDocumentor\Reflection\DocBlock\Tags\Throws;

/**
 * @method BlogEntry|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogEntry|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogEntry[]    findAll()
 * @method BlogEntry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogEntryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogEntry::class);
    }

    // /**
    //  * @return BlogEntry[] Returns an array of BlogEntry objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BlogEntry
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function delete($id)
    {
        $blogEntity = $this->find($id);
        if (is_null($blogEntity)) {
            throw new ORMException("Not found");
        }
        $this->getEntityManager()->remove($blogEntity);
        $this->getEntityManager()->flush();
    }


}
