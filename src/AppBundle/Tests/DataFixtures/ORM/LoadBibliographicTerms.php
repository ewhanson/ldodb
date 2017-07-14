<?php

namespace AppBundle\Tests\DataFixtures\ORM;

use AppBundle\Entity\BibliographicTerms;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadBibliographicTerms extends AbstractFixture implements OrderedFixtureInterface { 

    public function getOrder() {
        1;
    }

    public function load(ObjectManager $em) {
        $object = new BibliographicTerms();
        // DO STUFF HERE.
        $em->persist($object);
        $em->flush();
        $this->setReference('BibliographicTerms.1', $object);
    }

}
