<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use App\Entity\PropertySearch;
use Doctrine\ORM\Query;

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
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
            ->getQuery()
            ->getResult();
    }

    /**
     * @return property;
     */
    public function findLatest(): array
    {
        return $this->findVisibleQuery()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Query;
     */
    public function findSearchPropertyQuery(PropertySearch $search): Query
    {
        $query = $this->findVisibleQuery();
        if ($search->getMaxPrice()) {
            $query = $query->andWhere('p.price <= :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }
        if ($search->getMinSurface()) {
            $query = $query->andWhere('p.surface <= :minSurface')
                ->setParameter('minSurface', $search->getMinSurface());
        }
        /**
         * On met la possiblité de rechercher via les options
         * 
         *  */
        if ($search->getOptions()->count() > 0) {
            $k = 0; //on initialise k-0 pr que l'utlisateur ne ouise oas alterer notre requete, injectant ne=;importe quoi
            foreach ($search->getOptions() as $k => $option) {
                $k++;
                $query = $query->andWhere(":options$k MEMBER OF p.options")
                    ->setParameter("options$k", $option);
            }
        }
        $query = $query->orderBy('p.id', 'ASC')
            ->getQuery();
        return $query;
    }

    private function findVisibleQuery()
    {

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
