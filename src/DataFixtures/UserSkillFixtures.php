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
        ["a","0x00","PHP","débutant"],
        ["a","0x01","Symfony","débutant"],
        ["a","0x00","React","débutant"],
        ["b","0x01","PHP","intermédiaire"],
        ["b","0x00","React","expert"],
        ["c","0x01","Symfony","expert"],
    ];

    public function load(ObjectManager $manager)
    {

        foreach(self::FAKE_USER_SKILL as $fakeskill) {
            $userskill = new UserSkill();

            $userskill
            ->setUserId($manager->getRepository(User::class))->findOneBy(['firstname' => $fakeskill[0]])
            ->setLiked($fakeskill[1])
            ->setSkillId($manager->getRepository(Skill::class))->findOneBy(['name' => $fakeuser[2]])->findOneBy(['level' => $fakeuser[3]]);
            
                $manager->persist($userskill);
                $manager->flush();
        }
    }
}
