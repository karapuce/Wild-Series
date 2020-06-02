<?php


namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use App\Entity\Season;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SeasonFixtures extends Fixture implements DependentFixtureInterface
{


    public function load(ObjectManager $manager)
    {

        for ($i = 0 ; $i<20 ;$i++)
        {
            $season = new season();
            $faker = Faker\Factory::create('fr_FR');
            $season->setNumber($faker->numberBetween(1,10));
            $season->setYear(20 . $faker->numberBetween(10,20));
            $season->setDescription($faker->text(200));
            $season->setProgram($this->getReference('program_'.$faker->numberBetween(0,5)));
            $manager->persist($season);
            $this->addReference('season_id_' . ($i), $season);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}