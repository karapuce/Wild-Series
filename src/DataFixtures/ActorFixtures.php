<?php


namespace App\DataFixtures;

use App\Service\Slugify;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\Entity\Actor;
use App\Entity\Program;
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
            $slugify = new Slugify();
            $faker = Faker\Factory::create('fr_FR');
            $actor->setName($faker->name);
            $slug = $slugify->generate($actor->getName());
            $actor->setSlug($slug);
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