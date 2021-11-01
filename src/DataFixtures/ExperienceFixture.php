<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Company;
use App\Entity\Experience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExperienceFixture extends Fixture implements DependentFixtureInterface
{
    public const FAKE_EXPERIENCE = [
        ['Azer',"2002-06-02 23:59:59.99",NULL,"Développeur..","a","Designer"],
        ['Dfgh',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","A...","a","Développeur"],
        ['Opqs',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","A...","b","Data Analyst"],
        ['Dfgh',"2002-06-02 23:59:59.99",NULL,"Z...","b", "Stagiaire Café"],
        ['Jklm',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","E...","c", "Portier"],
        ['Wxcv',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","R...","d", "Laveur de voitures"],
        ['Bnaz',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","T...","e", "ingénieur système"]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::FAKE_EXPERIENCE as $fakeXp) {
            $start_at = new \DateTimeImmutable($fakeXp[1]);
            $end_at = new \DateTimeImmutable($fakeXp[2]);

            $xP = new Experience();

            $xP
            ->setCompany($manager->getRepository(Company::class)
            ->findOneBy(['name' => $fakeXp[0]]))
            ->setStartAt($start_at)
            ->setEndAt($end_at)
            ->setDetails($fakeXp[3])
            ->setUser($manager->getRepository(User::class)
            ->findOneBy(['firstname' => $fakeXp[4]]))
            ->setJob($fakeXp[5]);

            
            $manager->persist($xP);
            $manager->flush();
        }
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
}
