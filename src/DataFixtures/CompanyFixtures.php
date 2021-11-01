<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompanyFixtures extends Fixture
{
    public const FAKE_COMPANY = [
        ['Azer', "2 rue azer", "23.38.85.18.1232"],
        ['Opqs', "4 rue azer", "23.38.85.18.156"],
        ['Dfgh', "5 rue azer", "23.38.85.18.134"],
        ['Jklm', "6 rue azer", "23.38.85.18.1098"],
        ['Wxcv', "7 rue azer", "23.38.85.18.198"],
        ['Bnaz', "1 rue azer", "23.38.85.18.167"]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::FAKE_COMPANY as $fakeCompany) {

            $company = new Company();

            $company
                ->setName($fakeCompany[0])
                ->setAddress($fakeCompany[1])
                ->setContact($fakeCompany[2])
                ;

            $manager->persist($company);
            $manager->flush();
        }
    }
}
