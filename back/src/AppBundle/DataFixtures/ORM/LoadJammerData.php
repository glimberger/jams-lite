<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Jammer;
use AppBundle\Utils\Roles;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadJammerData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadJammerData implements FixtureInterface, ContainerAwareInterface
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
        $superAdminID = Uuid::uuid4();

        $superAdmin = new Jammer($superAdminID, 'glim.dev@gmail.com', 'glim');
        $superAdmin
            ->setRoles([Roles::ADMIN])
            ->setPlainPassword('Ddn@12081972')
            ->enable();

        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($superAdmin, $superAdmin->getPlainPassword());
        $superAdmin->setPassword($password);

        $manager->persist($superAdmin);
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
}