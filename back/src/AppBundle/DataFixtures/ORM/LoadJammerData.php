<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Jammer;
use AppBundle\Utils\Roles;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadJammerData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadJammerData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     *
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException
     * @throws \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function load(ObjectManager $manager): void
    {
        $jammers = [
            [
                'email' => 'glim.dev@gmail.com',
                'alias' => 'glim',
                'firstName' => 'Guillaume',
                'lastName' => 'Limberger',
                'roles' => [Roles::ADMIN],
                'plainPassword' => 'Ddn@12081972',
            ],
            [
                'email' => 'jsmith@example.com',
                'alias' => 'jsmith',
                'firstName' => 'John',
                'lastName' => 'Smith',
                'roles' => [Roles::USER],
                'plainPassword' => 'johnsmith2017',
            ]
        ];

        $encoder = $this->container->get('security.password_encoder');

        foreach ($jammers as $jammer) {
            $_jammer = new Jammer(Uuid::uuid4(), $jammer['email'], $jammer['alias']);
            $_jammer
                ->setFirstName($jammer['firstName'])
                ->setLastName($jammer['lastName'])
                ->setRoles($jammer['roles'])
                ->setPlainPassword($jammer['plainPassword'])
                ->enable();

            $password = $encoder->encodePassword($_jammer, $_jammer->getPlainPassword());
            $_jammer->setPassword($password);

            $manager->persist($_jammer);
        }

        $manager->flush();
    }

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 100;
    }
}