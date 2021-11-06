<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompanyFixtures extends Fixture
{
    public const FAKE_COMPANY = [
        ['Azer', "Alain", "Dubois", "02.47.53.10.11", "fakemail1@gmail.com"],
        ['Opqs', "Carl", "Lewis", "02.47.53.10.12", "fakemail2@gmail.com"],
        ['Dfgh', "Mickaël", "Jakson", "02.47.53.10.13", "fakemail3@gmail.com"],
        ['Jklm', "Pierre", "Leroux", "02.47.53.10.14", "fakemail4@gmail.com"],
        ['Wxcv', "Miguel", "Lamarre", "02.47.53.10.15", "fakemail5@gmail.com"],
        ['Bnaz', "Alain", "Martinez", "02.47.53.10.16", "fakemail6@gmail.com"]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::FAKE_COMPANY as $fakeCompany) {

            $company = new Company();

            $company
                ->setName($fakeCompany[0])
                ->setFirstname($fakeCompany[1])
                ->setLastname($fakeCompany[2])
                ->setPhone($fakeCompany[3])
                ->setEmail($fakeCompany[4]);

            $manager->persist($company);
            $manager->flush();
        }
    }
}
