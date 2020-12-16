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
        $brewer = $this->findOneBy(['name' => $data['name']]);

        if (!$brewer) {
            $brewer = new Brewery;
            $brewer->setName($data['brewery']);
            $brewer->setAddress($data['address']);
            $brewer->setCity($data['city']);
            $brewer->setState($data['state']);
            $brewer->setCountry($data['country']);
            $brewer->setCoordinates($data['coordinates']);
            $brewer->setWebsite($data['website']);
            $brewer->setCreatedAt(new \DateTime);
            $brewer->setUpdatedAt(new \DateTime);

            $this->em->persist($brewer);
            $this->em->flush();
        }

        return $brewer;
    }

}
