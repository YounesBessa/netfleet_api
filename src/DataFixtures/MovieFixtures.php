<?php

namespace App\DataFixtures;

use App\Entity\Movie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class MovieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        for ($i = 0; $i < 20; $i++) {
            $movie = (new Movie())
                ->setName('movie number' . $i)
                ->setSynopsis('lorem ipsum synopsis for movie number' . $i)
                ->setType($i % 2 === 0 ? 'movie' : 'series')
                ->setCreationDate(new \DateTimeImmutable('now'));
            $manager->persist($movie);
        }

        $manager->flush();
    }
}
