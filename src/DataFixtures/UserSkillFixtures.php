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
        ['Thedford',"PHP",1,1],
        ['Thedford','Symfony',2,1],
        ['Thedford','JavaScript',3,0],
        ['Thedford','Laravel',4,1],
        ['Campbell','JavaScript',5,0],
        ['Campbell','Java',2,1],
        ['Campbell','C++',3,1],
        ['Faure','Ruby',4,1],
        ['Faure','Java',5,0],
        ['Faure',"PHP",3,1],
        ['Pariseau','React',4,0],
        ['Pariseau','Python',5,0],
        ['Routhier',"PHP",3,1],
        ['Routhier','Laravel',2,0],
        ['Routhier','Symfony',1,1],
        ['Faurel','Meteor',5,1],
        ['Faurel','C++',2,1],
        ['Despins','Django',3,1],
        ['Despins','CSS',5,0],
        ['Lussier','C++',1,1],
        ['Lussier','JavaScript',2,1],
        ['Lussier','CSS',1,1],
        ['Tougas','Symfony',3,0],
        ['Tougas','React',2,1],
        ['Tougas','CSS',4,1],
        ['Artois',"PHP",2,0],
        ['Artois','Python',5,1],
        ['Levasseur','Laravel',3,0],
        ['Levasseur','Spring',1,1],
        ['Berie','Java',2,0],
        ['Berie','Ruby',4,1],
        ['Berie','C',3,1],
        ['Berie','Meteor',5,1],
        
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
