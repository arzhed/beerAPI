<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    private $container;
    private $em;

    public function __construct(ManagerRegistry $registry, ContainerInterface $container)
    {
        parent::__construct($registry, User::class);
        $this->container = $container;
        $this->em = $this->container->get('doctrine')->getManager();
    }

    public function create(array $data): User
    {
        $user = new User;
        $user->setEmail($data['email']);
        $user->setpassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $user->setPseudo($data['pseudo']);
        $user->setRole('standard');
        $user->setCreatedAt(new \DateTime);
        $user->setUpdatedAt(new \DateTime);

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

}
