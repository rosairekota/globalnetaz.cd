<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\PropertySearch;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }
    
    /**
     * @return property;
     */
    public function findAllVisible():array{
        return $this->findVisibleQuery()
                    ->getQuery()
                    ->getResult();
    }
    
    /**
     * @return property;
     */
    public function findLatest():array{
        return $this->findVisibleQuery()
                    ->setMaxResults(4)
                    ->getQuery()
                    ->getResult();
    }

    
    public function findSearchProperty(PropertySearch $search)
    {
        $query= $this->findVisibleQuery();
        if ($search->getMaxPrice()) {
            $query=$query->andWhere('p.price <= :maxPrice')
                         ->setParameter('maxPrice', $search->getMaxPrice());
        }
        elseif ($search->getMinSurface()) {
            $query=$query->andWhere('p.surface <= :minSurface')
                         ->setParameter('minSurface', $search->getMinSurface());
        }   
        $query=$query->orderBy('p.id', 'ASC')
                    ->setMaxResults(12)
                    ->getQuery()
                    ->getResult()
        ;
        return $query;
    }
    
    private function findVisibleQuery(){

        return $this->createQueryBuilder('p')
                    ->where('p.sold=false');
    }

   

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
