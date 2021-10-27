<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Experience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ExperienceFixture extends Fixture implements DependentFixtureInterface
{
    public const FAKE_EXPERIENCE = [
        ['Azer',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","Développeur..","a"],
        ['Tyui',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","A...","a"],
        ['Opqs',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","A...","b"],
        ['Dfgh',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","Z...","b"],
        ['Jklm',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","E...","c"],
        ['Wxcv',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","R...","d"],
        ['Bnaz',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","T...","e"]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach(self::FAKE_EXPERIENCE as $fakeXp) {
            $start_at = new \DateTimeImmutable($fakeXp[1]);
            $end_at = new \DateTimeImmutable($fakeXp[2]);

            $xP = new Experience();

            $xP
            ->setCompany($fakeXp[0])
            ->setStartAt($start_at)
            ->setEndAt($end_at)
            ->setDetails($fakeXp[3])
            ->setUser($manager->getRepository(User::class)
            ->findOneBy(['firstname' => $fakeXp[4]]));;
            
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
