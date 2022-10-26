<?php

namespace App\Tests\Entity;

use App\Entity\Movie;
use App\Entity\Person;
use PHPUnit\Framework\TestCase;

class MovieTest extends TestCase
{
    public function testActorsInMovie() {
        $actorJohnDoe = new Person();
        $actorJohnDoe
            ->setLastname("Doe")
            ->setFirstname("John");

        $actorJaneFlak = new Person();
        $actorJaneFlak
            ->setLastname("Flak")
            ->setFirstname("Jane");

        $movie = new Movie();
        $movie->setTitle("Mon film préféré");
        $movie->setDescription("Test");

        $movie
            ->addActor($actorJaneFlak)
            ->addActor($actorJohnDoe);

        $this->assertCount(2, $movie->getActors());

    }
}
