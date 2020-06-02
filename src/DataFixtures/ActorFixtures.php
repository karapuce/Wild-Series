<?php


namespace App\DataFixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Actor;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ActorFixtures extends Fixture implements DependentFixtureInterface
{
    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
        for ($i = 0 ; $i<50 ;$i++)
        {
            $actor = new Actor();
            $faker = Faker\Factory::create('fr_FR');
            $actor->setName($faker->name);
            $number = rand(1,4);
            $actor->addProgram($this->getReference('program_'.$number));
            $manager->persist($actor);
        }
        $manager->flush();

    }

    public function getDependencies()
    {
        return [ProgramFixtures::class];
    }
}