<?php

namespace App\Repository;

use App\Entity\Evento;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use App\Entity\Local;

/**
 * @method Evento|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evento|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evento[]    findAll()
 * @method Evento[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Evento::class);
    }

    // /**
    //  * @return Evento[] Returns an array of Evento objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    
    public function existeEvento(Evento $evento ): ?Evento
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.data = :data')
            ->andWhere('e.local = :local')
            ->andWhere('e.id != :id')
            ->setParameter('data', $evento->getData())
            ->setParameter('local', $evento->getLocal())
            ->setParameter('id', $evento->getId())
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    
}
