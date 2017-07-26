<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Sample
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="sample")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Sample
{
    use EntityTimestampableTrait;

    /**
     * @var UuidInterface
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var Sound
     *
     * @ORM\Embedded(class="AppBundle\Entity\Sound")
     */
    private $sound;

    /**
     * @var UploadedFile|File
     */
    private $soundFile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="collection", options={"comment":"The collection which this sample is part of"})
     */
    private $collection;

    /**
     * Track constructor.
     *
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
        $this
            ->setNewSound()
            ->setNoCollection();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return UploadedFile|File|null
     */
    public function getSoundFile()
    {
        return $this->soundFile;
    }

    /**
     * @param null|File|UploadedFile $soundFile
     *
     * @return Sample
     */
    public function setSoundFile($soundFile = null): Sample
    {
        $this->soundFile = $soundFile;

        if ($soundFile) {
            // It is required otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable());
        }

        return $this;
    }

    /**
     * @return Sound
     */
    public function getSound(): Sound
    {
        return $this->sound;
    }

    /**
     * @param Sound $sound
     *
     * @return Sample
     */
    public function setSound(Sound $sound): Sample
    {
        $this->sound = Sound::createFromSound($sound);

        return $this;
    }

    /**
     * @return Sample
     */
    public function setNewSound(): Sample
    {
        $this->sound = Sound::create(null, null);

        return $this;
    }

    /**
     * @return string
     */
    public function getCollection(): string
    {
        return $this->collection;
    }

    /**
     * @param string $collection
     * @return Sample
     */
    public function setCollection(string $collection): Sample
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @return Sample
     */
    public function setNoCollection(): Sample
    {
        $this->setCollection('');

        return $this;
    }
}