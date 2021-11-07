<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Address;
use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AddressFixtures extends Fixture implements DependentFixtureInterface
{
    public const FAKE_COMPANY_ADDRESS = [
        ['46','Place Napoléon','LAMBERSART', '59130' ,'France', 'TOTAL'],
        ['53','rue de Groussay','RODEZ', '12000', 'France' ,'CARREFOUR'],
        ['76','Avenue des Tuileries','GRIGNY ', '91350', 'France', 'GDF-SUEZ'],
        ['37','rue Isambard','FRANCONVILLE-LA-GARENNE', '95130', 'France', 'EDF'],
        ['35','rue Porte d\'Orange','CARPENTRAS', '84200', 'France', 'PSA PEUGEOT CITROEN'],
        ['12','rue Adolphe Wurtz','LE PUY-EN-VELAY', '43000', 'France', 'FRANCE TELECOM'],
        ['12','Rue des Alouettes','TOURS', '37000', 'France', 'GROUPE AUCHAN'],
        ['91','Avenue des Pr\'es','MONTMORENCY', '95160', 'France', 'SAINT-GOBAIN'],
        ['34','boulevard de la Liberation','MARSEILLE', '13013', 'France', 'LOUIS DREYFUS'],
        ['28','rue Sébastopol','SAINTES', '17100', 'France', 'E. LECLERC'],
        ['70','rue du Fossé des Tanneurs','TORCY', '77200', 'France', 'VEOLIA ENVIRONNEMENT'],
        ['78','rue de Geneve','AMIENS', '80080', 'France', 'GROUPE INTERMARCHE'],
        ['2','Place de la Gare','COMBS-LA-VILLE', '77380', 'France', 'RENAULT'],
        ['98','avenue de l\'Amandier','BOIS-COLOMBES', '92270', 'France', 'VINCI'],
        ['42','rue des Chaligny','NICE', '06300', 'France', 'BOUYGUES'],
    ];

    public const FAKE_USER_ADDRESS = [
        ['4A','Rue Marie De Médicis','CANNES-LA-BOCCA', '06150' ,'France', 'Thedford'],
        ['26','Rue du thé','Nante', '44000', 'France' ,'Campbell'],
        ['78','Rue Marie De Médicis','CANNES-LA-BOCCA', '06150', 'France', 'Faure'],
        ['23','rue de la République','LYON', '69004', 'France', 'Pariseau'],
        ['87','rue Clement Marot','PESSAC', '33600', 'France', 'Routhier'],
        ['9','rue de Groussay','ROMAINVILLE', '93230', 'France', 'Faurel'],
        ['12bis','Faubourg Saint Honoré','PARIS', '75019', 'France', 'Despins'],
        ['16','rue Beauvau','MARSEILLE', '13004' ,'France', 'Lussier'],
        ['4','rue de l\'Epeule','ROUBAIX', '59100' ,'France', 'Tougas'],
        ['76','Rue Hubert de Lisle','LUNEL', '34400' ,'France', 'Artois'],
        ['15','rue de l\'Epeule','ROUEN', '76000' ,'France', 'Levasseur'],
        ['20','Rue du Limas','BAYONNE', '64100' ,'France', 'Berie'],
        ['47','rue du Paillle en queue','LES MUREAUX', '78130' ,'France', 'Voisine'],
        ['83','rue du Gue Jacquet','CHATOU', '78400' ,'France', 'Sylvain'],
        ['82','rue Léon Dierx','LIVRY-GARGAN', '93190' ,'France', 'Saindon'],
        ['34','Chemin Du Lavarin Sud','CAHORS', '46000' ,'France', 'Dupont'],
        ['89','rue de la Mare aux Carats','MONTROUGE', '92120' ,'France', 'Auger'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::FAKE_COMPANY_ADDRESS as $fakeaddress) {
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
        foreach(self::FAKE_USER_ADDRESS as $fakeaddress) {
            $address = new Address();

            $address
            ->setNbRoad($fakeaddress[0])
            ->setRoad($fakeaddress[1])
            ->setCity($fakeaddress[2])
            ->setCp($fakeaddress[3])
            ->setCountry($fakeaddress[4])
            ->setUser($manager->getRepository(User::class)
            ->findOneBy(['lastname' => $fakeaddress[5]]))
            
            ;
            
            $manager->persist($address);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            CompanyFixtures::class,
            UserFixtures::class
        ];
    }
}
