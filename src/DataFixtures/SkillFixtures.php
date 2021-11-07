<?php

namespace App\DataFixtures;

use App\Entity\Skill;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class SkillFixtures extends Fixture
{
    public const FAKE_SKILL = [
        ['PHP'],
        ['Symfony'],
        ['React'],
        ['JavaScript'],
        ['Laravel'],
        ['Java'],
        ['Python'],
        ['Ruby'],
        ['C'],
        ['C#'],
        ['C++'],
        ['CSS'],
        ['Objective-C'],
        ['Django'],
        ['Angular'],
        ['ASP.net'],
        ['Meteor'],
        ['Express'],
        ['Spring']
    ];

    public function load(ObjectManager $manager)
    {

        foreach(self::FAKE_SKILL as $fakeSkill) {
            $skill = new Skill();

            $skill
            ->setName($fakeSkill[0]);
            
            $manager->persist($skill);
            $manager->flush();
        }
    }
}
