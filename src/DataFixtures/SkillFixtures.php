<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SkillFixtures extends Fixture
{
    public const FAKE_SKILL = [
        ['PHP','débutant',1],
        ['Symfony','débutant',0],
        ['React','débutant',1],
        ['PHP','intermédiaire',1],
        ['Symfony','intermédiaire',1],
        ['React','intermédiaire',1],
        ['PHP','expert',0],
        ['Symfony','expert',1],
        ['React','expert',1]
    ];

    public function load(ObjectManager $manager)
    {

        foreach(self::FAKE_SKILL as $fakeSkill) {
            $skill = new Skill();

            $skill
            ->setName($fakeSkill[0])
            ->setLevel($fakeSkill[1])
            ->setLiked($fakeSkill[2]);
            
            $manager->persist($skill);
            $manager->flush();
        }
    }
}
