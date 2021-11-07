<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public const FAKE_USER = [
        ['a@gmail.com',['ROLE_USER'],'Grace','Thedford','626-641-3494','Voisine',0],
        ['b@gmail.com',['ROLE_USER'],'Randall','Campbell','01.30.50.61.57','Voisine',1],
        ['c@gmail.com',['ROLE_USER'],'Yves','Faure','04.77.61.72.26','Voisine',1],
        ['d@gmail.com',['ROLE_USER'],'Felicien','Pariseau','05.25.76.50.99','Sylvain',1],
        ['e@gmail.com',['ROLE_USER'],'Charline','Routhier','04.77.61.72.26','Sylvain',1],
        ['f@gmail.com',['ROLE_USER'],'Yves','Faurel','02.16.58.93.98','Saindon',1],
        ['g@gmail.com',['ROLE_USER'],'Babette','Despins','04.04.18.99.28','Saindon',1],
        ['h@gmail.com',['ROLE_USER'],'Valérie','Lussier','05.62.90.33.05','Dupont',1],

        ['i@gmail.com',['ROLE_USER'],'Philip','Tougas','04.29.61.03.80',NULL,1],
        ['j@gmail.com',['ROLE_USER'],'Didier','Artois','04.29.61.03.85',NULL,1],
        ['k@gmail.com',['ROLE_USER'],'Baptiste','Levasseur','04.99.70.64.23',NULL,0],
        ['l@gmail.com',['ROLE_USER'],'Liane','Berie','05.25.76.50.99',NULL,1],
    ];

    public const FAKE_ADMIN = [
        ['v@gmail.com',['ROLE_ADMIN'],'Burnell','Voisine','03.21.44.69.30'],
        ['w@gmail.com',['ROLE_ADMIN'],'Armand','Sylvain','03.89.75.57.62'],
        ['x@gmail.com',['ROLE_ADMIN'],'Yvon','Saindon','01.13.08.74.37'],
        ['y@gmail.com',['ROLE_ADMIN'],'Vallis','Dupont','03.43.17.39.84'],
    ];

    public function load(ObjectManager $manager)
    {
        $date = new DateTimeImmutable();
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
            ->setPhone($fakeadmin[4])
            ->setVisibility(0)
            ->setChangedAt($date)
            ;
                
                
                

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
            ->setPhone($fakeuser[4])
            ->setParent($manager->getRepository(User::class)
            ->findOneBy(['lastname' => $fakeuser[5]]))
            ->setVisibility($fakeuser[6])
            ->setChangedAt($date)
            ;

            $manager->persist($user);
            $manager->flush();
        }
        $manager->persist($this->createSuperAdminUser());
        $manager->flush();

        $manager->flush();
    }

    private function createSuperAdminUser(): User
    {
        $date = new DateTimeImmutable();
        $admin = new User;

        $admin
        ->setEmail('z@gmail.com')
        ->setRoles(['ROLE_SUPER_ADMIN'])
        ->setPassword(
            $this->userPasswordHasher->hashPassword($admin, 'a')
        )
        ->setFirstname('Mickaël')
        ->setLastname('Auger')
        ->setPhone('23.38.85.18.15')
        ->setVisibility(0)
        ->setChangedAt($date)
        ;

        return $admin;
    }
}
