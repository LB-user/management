<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompanyFixtures extends Fixture
{
    public const FAKE_COMPANY = [
        ['TOTAL', "Alain", "Dubois", "02.47.53.10.11", "fakemail1@gmail.com"],
        ['CARREFOUR', "Carl", "Lewis", "02.47.53.10.12", "fakemail2@gmail.com"],
        ['GDF-SUEZ', "Mickaël", "Jakson", "02.47.53.10.13", "fakemail3@gmail.com"],
        ['EDF', "Pierre", "Leroux", "02.47.53.10.14", "fakemail4@gmail.com"],
        ['PSA PEUGEOT CITROEN', "Miguel", "Lamarre", "02.47.53.10.15", "fakemail5@gmail.com"],
        ['FRANCE TELECOM', "Alain", "Martinez", "02.47.53.10.16", "fakemail6@gmail.com"],
        ['GROUPE AUCHAN', "Coralie", "Bonnet", "05.17.91.13.18", "fakemail7@gmail.com"],
        ['SAINT-GOBAIN', "Landers", "Fortier", "04.99.96.88.53", "fakemail8@gmail.com"],
        ['LOUIS DREYFUS', "Faye", "Fréchette", "03.38.04.96.45", "fakemail9@gmail.com"],
        ['E. LECLERC', "Vivienne", "Méthot", "01.20.48.73.53", "fakemail10@gmail.com"],
        ['VEOLIA ENVIRONNEMENT', "Fabrice", "Verreau", "02.62.10.75.78", "fakemail11@gmail.com"],
        ['GROUPE INTERMARCHE', "Agate", "Gauthier", "02.47.59.10.16", "fakemail12@gmail.com"],
        ['RENAULT', "Archard", "Lanoie", "01.18.71.03.51", "fakemail13@gmail.com"],
        ['VINCI', "Octave", "Hétu", "01.99.81.07.87", "fakemail14@gmail.com"],
        ['BOUYGUES', "Pansy", "Beaujolie", "05.90.02.25.356", "fakemail15@gmail.com"],
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
