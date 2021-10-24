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
        ["a","PHP","débutant"],
        ["a","Symfony","débutant"],
        ["a","React","débutant"],
        ["b","PHP","intermédiaire"],
        ["b","React","expert"],
        ["c","Symfony","expert"],
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
                'name' => $fakeuserskill[1],
                'level' => $fakeuserskill[2]
            ]));
            
                $manager->persist($userskill);
                $manager->flush();
        }
    }
}
