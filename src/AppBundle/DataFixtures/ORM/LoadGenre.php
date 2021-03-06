<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Genre;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadGenre extends AbstractFixture {

    public function load(ObjectManager $em) {
        $object = new Genre();
        $object->setGenreName('extinct');
        $object->setGenreSource('phylogenic studies');
        $object->setGenreUri('http://example.com/genre/extinct');
        $object->setGenreUsageNote('Not to be used with Dunkleosteus because they rock.');
        $em->persist($object);
        $em->flush();
        $this->setReference('Genre.1', $object);
    }

}
