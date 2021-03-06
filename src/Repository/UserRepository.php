<?php

namespace App\Repository;

use App\Entity\User;
use App\Entity\Skill;
use App\Entity\UserSkill;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findUsersByLastName(string $query)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->like('u.lastname', ':query'),
                    $qb->expr()->like('u.firstname', ':query')
                )
            )
            ->setParameter('query', '%' . $query . '%');
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findUsersBySkillName(string $query)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->innerJoin(UserSkill::class, 'us', 'WITH', 'us.user_id = u.id')
            ->innerJoin(Skill::class, 's', 'WITH', 's.id = us.skill_id')
            ->where(
                        $qb->expr()->like('s.name', ':query')
            )
            ->setParameter('query', '%' . $query . '%');
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function findUsersByAppetence(string $query)
    {
        $qb = $this->createQueryBuilder('u');
        $qb
            ->innerJoin(UserSkill::class, 'us', 'WITH', 'us.user_id = u.id')
            ->innerJoin(Skill::class, 's', 'WITH', 's.id = us.skill_id')
            ->where(
                    $qb->expr()->andX(
                        $qb->expr()->like('s.name', ':query'),
                        $qb->expr()->eq('us.liked', 1),
                    )
            )
            ->setParameter('query', '%' . $query . '%');
        return $qb
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
