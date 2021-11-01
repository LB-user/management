<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Experience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const FAKE_USER = [
        ['a@gmail.com',['ROLE_USER'],'a','a','a','a','f',0],
        ['b@gmail.com',['ROLE_USER'],'b','b','b','b','f',1],
        ['c@gmail.com',['ROLE_USER'],'c','c','c','c','g',1],
        ['d@gmail.com',['ROLE_USER'],'d','d','d','d',NULL,0],
        ['e@gmail.com',['ROLE_USER'],'e','e','e','e',NULL,1]
    ];

    public const FAKE_ADMIN = [
        ['f@gmail.com',['ROLE_ADMIN'],'f','f','f','f'],
        ['g@gmail.com',['ROLE_ADMIN'],'g','g','g','g']
    ];
    
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {

        foreach(self::FAKE_ADMIN as $fakeadmin) {
            $user = new User();

            $user
            ->setEmail($fakeadmin[0])
            ->setRoles($fakeadmin[1])
            ->setPassword(
                $this->userPasswordHasher->hashPassword($user, 'a')
            )
            ->setFirstname($fakeadmin[2])
            ->setLastname($fakeadmin[3])
            ->setAddress($fakeadmin[4])
            ->setPhone($fakeadmin[5])
            ->setVisibility(0);
                
                
                

                $manager->persist($user);
                $manager->flush();
        }

        foreach(self::FAKE_USER as $fakeuser) {
            $user = new User();

            $user
            ->setEmail($fakeuser[0])
            ->setRoles($fakeuser[1])
            ->setPassword(
                $this->userPasswordHasher->hashPassword($user, 'a')
            )
            ->setFirstname($fakeuser[2])
            ->setLastname($fakeuser[3])
            ->setAddress($fakeuser[4])
            ->setPhone($fakeuser[5])
            ->setParent($manager->getRepository(User::class)
            ->findOneBy(['firstname' => $fakeuser[6]]))
            ->setVisibility($fakeuser[7]);

            $manager->persist($user);
            $manager->flush();
        }
        $manager->persist($this->createSuperAdminUser());
        $manager->flush();

        $manager->flush();
    }

    private function createSuperAdminUser(): User
    {
        $admin = new User;

        $admin
        ->setEmail('z.z@z.fr')
        ->setRoles(['ROLE_SUPER_ADMIN'])
        ->setPassword(
            $this->userPasswordHasher->hashPassword($admin, 'z')
        )
        ->setFirstname('Z')
        ->setLastname('Z')
        ->setAddress('Pas là non plus')
        ->setPhone('23.38.85.18.15')
        ->setVisibility(0);

        return $admin;
    }
}
