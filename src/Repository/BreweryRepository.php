<?php

namespace App\Repository;

use App\Entity\Brewery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @method Brewery|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brewery|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brewery[]    findAll()
 * @method Brewery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BreweryRepository extends ServiceEntityRepository
{
    private $container;
    private $em;

    public function __construct(ManagerRegistry $registry, ContainerInterface $container)
    {
        parent::__construct($registry, Brewery::class);
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    public function findOrCreateFromArray(array $data)
    {
        $brewer = $this->findOneBy(['name' => $data[15]]);

        if (!$brewer) {
            $brewer = new Brewery;
            $brewer->setName($data[15]);
            $brewer->setAddress($data[16]);
            $brewer->setCity($data[17]);
            $brewer->setState($data[18]);
            $brewer->setCountry($data[19]);
            $brewer->setCoordinates($data[20]);
            $brewer->setWebsite($data[21]);
            $brewer->setCreatedAt(new \DateTime);
            $brewer->setUpdatedAt(new \DateTime);

            $this->em->persist($brewer);
            $this->em->flush();
        }

        return $brewer;
    }

}
