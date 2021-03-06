<?php

namespace RuchJow\UserBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use RuchJow\UserBundle\Entity\Organisation;

class LoadOrganisationsData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $repo = $manager->getRepository('RuchJowUserBundle:Organisation');

        $faker = \Faker\Factory::create('pl_PL');

        for ($i = 1; $i <= 20; $i++)
        {
            $organisation = new Organisation();
            $organisation->setName($faker->company);
            $organisation->setUrl(preg_replace('/(https?:\/\/)?([^\/]+).*/', '$2', $faker->url));

            $manager->persist($organisation);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 12; // the order in which fixtures will be loaded
    }
}