<?php

namespace OC\BackBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OC\BackBundle\Entity\Observation;
use OC\BackBundle\Entity\Image;
use OC\BackBundle\Entity\User;

class LoadObservationData extends AbstractFixture implements FixtureInterface
{
    const NB_MAX_OBSERVATIONS = 15;
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        // Création de fausses observations
        $faker = \Faker\Factory::create();

        $user = new User();
        $user->setFirstname("John");
        $user->setLastname("Doe");
        $user->setUsername('johndoe');
        $user->setEmail("johndoe@mail.com");
        $user->setCategory("observateur");
        $user->setPassword('test');
        $user->setEnabled(1);

        $manager->persist($user);

        for ($i = 0; $i < self::NB_MAX_OBSERVATIONS; $i++)
        {
            $image = new Image();

            $image->setAlt('fixture');
            $image->setUrl('fixture.png');

            $observation = new Observation();
            $observation->setImage($image);
            $observation->setTitle($faker->text(30));
            $observation->setDsc($faker->text(125));
            $observation->setLatitude('48.8582');
            $observation->setLongitude('2.3387');
            $observation->setValidated(rand(0,1));
            $observation->setUser($user);

            $manager->persist($observation);
        }

        $manager->flush();
    }
}