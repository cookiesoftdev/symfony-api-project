<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 10; $i++) {
            $category = new Category();
            $category->setName('Category '.$i);
            $category->setDescription('Description '.$i);
            $category->setPicture('https://via.placeholder.com/150');
            $category->setStatus(1);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
