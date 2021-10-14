<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public const FAKE_USER = [
        ['a@gmail.com',['ROLE_USER'],'a','a','a','a'],
        ['b@gmail.com',['ROLE_USER'],'b','b','b','b'],
        ['c@gmail.com',['ROLE_USER'],'c','c','c','c'],
        ['d@gmail.com',['ROLE_USER'],'d','d','d','d'],
        ['e@gmail.com',['ROLE_USER'],'e','e','e','e'],
    ];
    
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {

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
            ->setPhone($fakeuser[5]);
                
                
                

                $manager->persist($user);
            // $product = new Product();
            // $manager->persist($product);
        }

        $manager->persist($this->createAdminUser());
        $manager->flush();

        $manager->flush();
    }

    private function createAdminUser(): User
    {
        $admin = new User;

        $admin
        ->setEmail('a.a@a.fr')
        ->setRoles(['ROLE_ADMIN'])
        ->setPassword(
            $this->userPasswordHasher->hashPassword($admin, 'a')
        )
        ->setFirstname('A')
        ->setLastname('A')
        ->setAddress('Pas là')
        ->setPhone('12.38.85.18.15');

        return $admin;
    }
}
