<?php

namespace App\DataFixtures;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Program;
use App\Service\Slugify;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create('fr_FR');

        for ($i = 1; $i <= 1000; $i++) {
            $category = new Category();
            $category->setName($faker->word);
            $manager->persist($category);
            $this->addReference("category_$i", $category);

            $program = new Program();
            $slugify = new Slugify();
            $program->setTitle($faker->sentence(4, true));
            $program->setSummary($faker->text(100));
            $slug = $slugify->generate($program->getTitle());
            $program->setSlug($slug);
            $program->setCategory($this->getReference("category_".rand(1,$i)));
            $this->addReference("program_".$i, $program);
            $manager->persist($program);

            for($j = 1; $j <= 5; $j ++) {
                $actor = new Actor();
                $slugify = new Slugify();
                $actor->setName($faker->name);
                $slug = $slugify->generate($actor->getName());
                $actor->setSlug($slug);
                $actor->addProgram($this->getReference("program_$i"));
                $manager->persist($actor);
            }

        }

        $manager->flush();
    }
}
