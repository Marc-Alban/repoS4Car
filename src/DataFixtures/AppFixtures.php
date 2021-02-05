<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Image;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 10; $i++) {
            $image = new Image();
            $image->setName("default.png");
            $car = (new Car());
                $car->setModel(array_rand(array_flip(['peugeot', 'opel', 'audi', 'bmw', 'fiat', 'ford', 'renault', 'nissan', 'dodge', 'honda', 'lexus', 'subaru', 'suzuki'])))
                ->setCarburant(array_rand(array_flip(['essence','hybride','electrique','diesel'])))
                ->setColor($faker->colorName)
                ->setPrice(random_int(100,5000))
                ->setImage($image);

            $manager->persist($car);
            $manager->flush();
        }
    }
}
