<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=\Faker\Factory::create('fr_FR');
        for ($i=0; $i < 100; $i++) { 
            $property=new Property();
            $property->setTitle($faker->words(3,true))
                    ->setPrice($faker->numberBetween(100000,1000000))
                    ->setRooms($faker->numberBetween(2, 10))
                    ->setBedrooms($faker->numberBetween(1,9))
                    ->setDescription($faker->paragraph())
                    ->setSurface($faker->numberBetween(20,350))
                    ->setFloor($faker->numberBetween(0,15))
                    ->setHeat($faker->numberBetween(0, \count(Property::HEAT)-1))
                    ->setCity($faker->city)
                    ->setAdress($faker->address)
                    ->setPostalCode($faker->postcode);
            $manager->persist($property);
        }

        $manager->flush();
    }
}
