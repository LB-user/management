<?php

namespace App\DataFixtures;

use App\Entity\Experience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ExperienceFixture extends Fixture
{
    public const FAKE_EXPERIENCE = [
        ['Azer',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","Développeur.."],
        ['Tyui',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","A..."],
        ['Opqs',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","A..."],
        ['Dfgh',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","Z..."],
        ['Jklm',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","E..."],
        ['Wxcv',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","R..."],
        ['Bnaz',"2002-06-02 23:59:59.99","2003-04-23 23:59:59.99","T..."]
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
            ->setDetails($fakeXp[3]);
            
            $manager->persist($xP);
            $manager->flush();
        }
    }
}
