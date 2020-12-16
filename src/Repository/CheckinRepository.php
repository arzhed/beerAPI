<?php

namespace App\Repository;

use App\Entity\Checkin;
use App\Entity\Beer;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @method Checkin|null find($id, $lockMode = null, $lockVersion = null)
 * @method Checkin|null findOneBy(array $criteria, array $orderBy = null)
 * @method Checkin[]    findAll()
 * @method Checkin[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CheckinRepository extends ServiceEntityRepository
{
    private $container;
    private $em;

    public function __construct(ManagerRegistry $registry, ContainerInterface $container)
    {
        parent::__construct($registry, Checkin::class);
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    public function createOrUpdate(float $note, Beer $beer, User $user): Checkin
    {
        $checkin = $this->findOneBy(['beer' => $beer, 'user' => $user]);
        if ($checkin) {
            $checkin->setNote($note);
            $checkin->setUpdatedAt(new \DateTime);
        } else {
            $checkin = new Checkin;
            $checkin->setBeer($beer);
            $checkin->setUser($user);
            $checkin->setNote($note);
            $checkin->setCreatedAt(new \DateTime);
            $checkin->setUpdatedAt(new \DateTime);
            $this->em->persist($checkin);
        }

        $this->em->flush();

        return $checkin;
    }
}
