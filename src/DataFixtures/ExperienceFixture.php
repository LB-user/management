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
        ['TOTAL', "2021-06-02 23:59:59.99", "2021-08-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Thedford", "Designer"],
        ['TOTAL', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Thedford", "Designer"],
        ['TOTAL', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Campbell", "Designer"],
        ['CARREFOUR', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Faure", "Designer"],
        ['GDF-SUEZ', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Pariseau", "Designer"],
        ['EDF', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Routhier", "Designer"],
        ['PSA PEUGEOT CITROEN', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Faurel", "Designer"],
        ['FRANCE TELECOM', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Despins", "Designer"],
        ['GROUPE AUCHAN', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Lussier", "Designer"],
        ['SAINT-GOBAIN', "2021-06-02 23:59:59.99", NULL, "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Dupont", "Designer"],
        ['GROUPE INTERMARCHE', "2021-06-02 23:59:59.99", "2021-09-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Voisine", "Designer"],
        ['RENAULT', "2021-06-02 23:59:59.99", "2021-09-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Sylvain", "Designer"],
        ['VINCI', "2021-06-02 23:59:59.99", "2021-09-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Saindon", "Designer"],
        ['BOUYGUES', "2021-06-02 23:59:59.99", "2021-09-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Dupont", "Designer"],
        ['CARREFOUR', "2021-06-02 23:59:59.99", "2021-08-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Campbell", "Designer"],
        ['BOUYGUES', "2021-06-02 23:59:59.99", "2021-09-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Faure", "Designer"],
        ['VEOLIA ENVIRONNEMENT', "2021-06-02 23:59:59.99", "2021-07-02 23:59:59.99", "Lorem ipsum dolor sit amet consectetur, adipisicing elit. Saepe inventore atque ab iste? Impedit quia nesciunt dignissimos deserunt excepturi ut nisi soluta porro corrupti, ipsum optio doloremque ad placeat hic.
Illum alias impedit aliquid non, vero beatae fugiat nulla consequuntur reiciendis voluptas aut quo excepturi ratione quae dignissimos quas est ullam perspiciatis molestiae quaerat, esse tempora aliquam. Consequuntur, non incidunt!", "Pariseau", "Designer"]

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::FAKE_EXPERIENCE as $fakeXp) {
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
                    ->findOneBy(['lastname' => $fakeXp[4]]))
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
