<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SkillFixtures extends Fixture
{
    public const FAKE_SKILL = [
        ['PHP','débutant'],
        ['Symfony','débutant'],
        ['React','débutant'],
        ['PHP','intermédiaire'],
        ['Symfony','intermédiaire'],
        ['React','intermédiaire'],
        ['PHP','expert'],
        ['Symfony','expert'],
        ['React','expert']
    ];

    public function load(ObjectManager $manager)
    {

        foreach(self::FAKE_SKILL as $fakeSkill) {
            $skill = new Skill();

            $skill
            ->setName($fakeSkill[0])
            ->setLevel($fakeSkill[1]);
            
            $manager->persist($skill);
            $manager->flush();
        }
    }
}
