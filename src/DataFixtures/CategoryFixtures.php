<?php


namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;


class CategoryFixtures extends \Doctrine\Bundle\FixturesBundle\Fixture
{
    const CATEGORIES = [
        "Comédie",
        "Action",
        "Romance",
        "Horreur",
        "Drame"
    ];

    /**
     * @inheritDoc
     */
    public function load(ObjectManager $manager)
    {
       foreach (self::CATEGORIES as $key=> $categoryName) {
           $category = new Category();
           $category->setName($categoryName);
           $manager->persist($category);
           $this->addReference('categorie_' . $key, $category);
       }

       $manager->flush();
    }
}