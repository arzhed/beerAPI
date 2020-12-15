<?php

namespace App\Repository;

use App\Entity\Beer;
use App\Entity\Brewery;
use App\Entity\Category;
use App\Entity\Style;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @method Beer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Beer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Beer[]    findAll()
 * @method Beer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BeerRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry, ContainerInterface $container)
    {
        parent::__construct($registry, Beer::class);
    }

    protected function cleanData(Array $data)
    {
        foreach ($data as $key => &$value) {
            $value = empty($value) ? null : $value;
            if ($key == 12 && !is_null($value)) {
                $value = \DateTime::createFromFormat("U", strtotime($data[12]));
            }
        }

        return $data;
    }


    public function createFromArray(Array $data, Brewery $brewer, Category $cat, Style $style)
    {
        $data = $this->cleanData($data);

        if ($this->find($data[1])) {
            return false;
        }

        $beer = new Beer();
        $beer->setName($data[0]);
        $beer->setId((int)$data[1]);
        $beer->setAbv($data[5]);
        $beer->setIbu($data[6]);
        $beer->setDescription($data[10]);
        // $beer->setAddUser((int)$data[11]);
        $beer->setLastMod($data[12]);

        $beer->setBrewery($brewer);
        $beer->setStyle($style);
        $beer->setCategory($cat);

        return $beer;
    }

    // /**
    //  * @return Beer[] Returns an array of Beer objects
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
    public function findOneBySomeField($value): ?Beer
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
