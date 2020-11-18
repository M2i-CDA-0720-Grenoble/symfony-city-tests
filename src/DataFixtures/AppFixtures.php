<?php

namespace App\DataFixtures;

use App\Entity\City;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $response = \file_get_contents('https://geo.api.gouv.fr/departements/38/communes?fields=nom,centre');
        $data = \json_decode($response);

        foreach ($data as $cityData) {
            $city = new City;
            $city
                ->setName($cityData->nom)
                ->setLongitude($cityData->centre->coordinates[0])
                ->setLatitude($cityData->centre->coordinates[1])
            ;
            $manager->persist($city);
        }

        $manager->flush();
    }
}
