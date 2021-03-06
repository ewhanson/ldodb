<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Role;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadRole extends AbstractFixture {

    public function load(ObjectManager $em) {
        $object = new Role();
        $object->setRoleName('fishmonger');
        $em->persist($object);
        $em->flush();
        $this->setReference('Role.1', $object);
    }

}
