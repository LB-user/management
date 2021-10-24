<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Skill;
use App\Entity\UserSkill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserSkillFixtures extends Fixture
{
    public const FAKE_USER_SKILL = [
        ["a","PHP",1,1],
        ["a","Symfony",2,1],
        ["a","React",3,0],
        ["b","PHP",4,1],
        ["b","Laravel",5,1],
        ["c","Python",2,1],
    ];

    public function load(ObjectManager $manager)
    {
        foreach(self::FAKE_USER_SKILL as $fakeuserskill) {
            $userskill = new UserSkill();

            $userskill
            ->setUserId($manager->getRepository(User::class)
            ->findOneBy(['lastname' => $fakeuserskill[0]]))
            ->setSkillId($manager->getRepository(Skill::class)
            ->findOneBy([
                'name' => $fakeuserskill[1]
            ]))
            ->setLevel($fakeuserskill[2])
            ->setLiked($fakeuserskill[3]);
            
                $manager->persist($userskill);
                $manager->flush();
        }
    }
}
