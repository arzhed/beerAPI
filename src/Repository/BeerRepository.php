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

    protected function validate(Array $data)
    {
        foreach ($data as $key => &$value) {
            switch ($key) {
                case 1:
                case 6:
                    $value = (int) (is_numeric($value) ? $value : 0);
                    break;
                case 5:
                    $value = (float)(is_numeric($value) ? $value : 0.0);
                    break;
                case 12:
                    $value = \DateTime::createFromFormat("U", strtotime($data[12]));
                    if (!$value)
                        $value = new \DateTime;
                    break;
                default:
            }
        }

        return $data;
    }

    public function get(?string $sort, int $offset = 0, int $limit = 5): array
    {
        $qb = $this->createQueryBuilder('b')
                   ->select('b.id, b.name, b.abv, b.ibu, b.description, b.last_mod')
                   ->addSelect('identity(b.category) as category_id')
                   ->addSelect('identity(b.style) as style_id')
                   ->addSelect('identity(b.brewery) as brewery_id')
                   ->setFirstResult($offset)
                   ->setMaxResults($limit);

        switch ($sort) {
            case 'abv':
            case 'ibu':
                $qb->orderBy("b.$sort", 'DESC');
                break;
            default:
        }

        $query = $qb->getQuery();
        return $query->getResult();
    }


    public function createFromArray(Array $data, Brewery $brewer, Category $cat, Style $style): ?Beer
    {
        $data = $this->validate($data);

        if (!$data || $this->find($data[1])) {
            return null;
        }

        $beer = new Beer();
        $beer->setName($data[0]);
        $beer->setId((int)$data[1]);
        $beer->setAbv($data[5]);
        $beer->setIbu($data[6]);
        $beer->setDescription($data[10]);
        // $beer->setAddUser((int)$data[11]);
        $beer->setCreatedAt($data[12]);
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
