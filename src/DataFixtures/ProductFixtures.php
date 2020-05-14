<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
       
       
        $faker=\Faker\Factory::create('fr_FR');
        for ($i=0; $i < 100; $i++) { 
            $product = new Product();
            $product->setTitle($faker->words(3,true))
                    ->setPrice($faker->numberBetween(100000,1000000))
                    ->setDescription($faker->paragraph())
                    ->setImage($faker->imageUrl());
                    
             $manager->persist($product);
        }

        $manager->flush();
    }
}
