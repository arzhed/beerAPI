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

    protected function validate(Array $data)
    {
        foreach ($data as $key => &$value) {
            switch ($key) {
                case 'id':
                case 'ibu':
                    $value = (int) (is_numeric($value) ? $value : 0);
                    break;
                case 'abv':
                    $value = (float)(is_numeric($value) ? $value : 0.0);
                    break;
                case 'created_at':
                case 'last_mod':
                    $value = \DateTime::createFromFormat("U", strtotime($value));
                    if (!$value)
                        $value = new \DateTime;
                    break;
                default:
            }
        }

        return $data;
    }

    public function createFromArray(Array $data, ?Brewery $brewer, ?Category $cat = null, ?Style $style = null): ?Beer
    {
        $data = $this->validate($data);

        if (!$data || $this->findOneBy(['name' => $data['name']])) {
            return null;
        }

        $beer = new Beer();
        $beer->setName($data['name']);
        $beer->setAbv($data['abv']);
        $beer->setIbu($data['ibu']);
        $beer->setDescription($data['description'] ?? null);
        $beer->setCreatedAt($data['created_at'] ?? new \DateTime);
        $beer->setLastMod($data['last_mod'] ?? new \DateTime);

        $beer->setBrewery($brewer);
        $beer->setStyle($style);
        $beer->setCategory($cat);

        return $beer;
    }

}
