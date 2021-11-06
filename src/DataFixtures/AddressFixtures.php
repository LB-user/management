<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public const FAKE_ADDRESS = [
        ['46','Rue pistouille','Tours', '37000' ,'France', 'Azer'],
        ['89','Rue du charme','Nante', '44000', 'France' ,'Opqs'],
        ['98','Avenue deparla','NY', '10002', 'Etats-Unis', 'Dfgh'],
        ['37','Rue lol','Boston', '02108', 'Etats-Unis', 'Jklm'],
        ['35','Rue boustifaille','Montreal', '11290', 'Canada', 'Bnaz'],
        ['12','Rue des Alouettes','Tours', '37000', 'France', 'Wxcv']
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::FAKE_ADDRESS as $fakeaddress) {
            $address = new Address();

            $address
            ->setNbRoad($fakeaddress[0])
            ->setRoad($fakeaddress[1])
            ->setCity($fakeaddress[2])
            ->setCp($fakeaddress[3])
            ->setCountry($fakeaddress[4])
            ->setCompany($manager->getRepository(Company::class)
            ->findOneBy(['name' => $fakeaddress[5]]))
            
            ;
            
            $manager->persist($address);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
        ];
    }
}
