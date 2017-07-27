<?php
declare(strict_types = 1);

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Sample;
use AppBundle\Entity\Sound;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Finder\SplFileInfo;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\CS\Finder;

class LoadSampleData implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     * @throws \Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException
     * @throws \Symfony\Component\HttpFoundation\File\Exception\FileException
     */
    public function load(ObjectManager $manager)
    {
        $collection = 'TR-808';
        $fromDir = $this->container->getParameter('kernel.root_dir') . '/fixtures/samples/' .$collection;
        $toDir = $this->container->getParameter('sample_directory').'/'.$collection . '/';

        $finder = new Finder();
        $finder->files()->name('*.wav');

        /** @var SplFileInfo $info */
        foreach ($finder->in($fromDir) as $info) {
            $sample = new Sample(Uuid::uuid4());

            $file = new File($info->getPathname());
            $originalName = $file->getFilename();
            $fileName = $sample->getId()->toString().'.'.$file->guessExtension();
            $file = $file->move($toDir, $fileName);

            $sample
                ->setSound(Sound::createFromFile($file, $originalName))
                ->setCollection($collection);

            $manager->persist($sample);
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
        return 10;
    }
}