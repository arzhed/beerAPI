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

    public function create(array $data): Brewery
    {
        $brewer = new Brewery;
        $brewer->setName($data['brewery'] ?? null);
        $brewer->setAddress($data['address'] ?? null);
        $brewer->setCity($data['city'] ?? null);
        $brewer->setState($data['state'] ?? null);
        $brewer->setCountry($data['country'] ?? null);
        $brewer->setCoordinates($data['coordinates'] ?? null);
        $brewer->setWebsite($data['website'] ?? null);
        $brewer->setCreatedAt(new \DateTime);
        $brewer->setUpdatedAt(new \DateTime);

        $this->em->persist($brewer);
        $this->em->flush();

        return $brewer;
    }

    public function findOrCreateFromArray(array $data): Brewery
    {
        $brewer = $this->findOneBy(['name' => $data['brewery']]);

        if (!$brewer) {
            $brewer = $this->create($data);
        }

        return $brewer;
    }

    public function update(Brewery $brewer, array $data)
    {
        if (isset($data['name'])) {
            $other = $this->findOneBy(['name' => $data['name']]);
            if ($other) {
                throw new \Exception("Name already taken");
            }
            $brewer->setName($data['name']);
        }
        if (isset($data['address'])) {
            $brewer->setAddress($data['address']);
        }
        if (isset($data['city'])) {
            $brewer->setCity($data['city']);
        }
        if (isset($data['state'])) {
            $brewer->setState($data['state']);
        }
        if (isset($data['country'])) {
            $brewer->setCountry($data['country']);
        }
        if (isset($data['coordinates'])) {
            $brewer->setCoordinates($data['coordinates']);
        }
        if (isset($data['website'])) {
            $brewer->setWebsite($data['website']);
        }

        $brewer->setUpdatedAt(new \DateTime);

        $this->em->flush();

        return $brewer;
    }

}
