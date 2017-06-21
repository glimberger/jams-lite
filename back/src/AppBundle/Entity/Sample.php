<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Entity\File as EmbeddedFile;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class Sample
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="sample")
 * @ORM\Entity()
 */
final class Sample
{
    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @var EmbeddedFile
     *
     * @ORM\Embedded(class="Vich\UploaderBundle\Entity\File")
     */
    private $sound;

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(
     *     mapping="sample",
     *     fileNameProperty="sound.name",
     *     mimeType="sound.mimeType",
     *     originalName="sound.originalName",
     *     size="sound.size"
     * )
     */
    private $soundFile;

    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Track constructor.
     *
     * @param Uuid $id
     */
    public function __construct(Uuid $id)
    {
        $this->id = $id;
        $this->sound = new EmbeddedFile();
    }

    /**
     * @return Uuid
     */
    public function getId(): Uuid
    {
        return $this->id;
    }

    /**
     * @return File|null
     */
    public function getSoundFile(): File
    {
        return $this->soundFile;
    }

    /**
     * @param null|File|UploadedFile $sound
     *
     * @return Sample
     */
    public function setSoundFile(?File $sound = null): Sample
    {
        $this->soundFile = $sound;

        if ($sound) {
            // It is required otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return EmbeddedFile
     */
    public function getSound(): EmbeddedFile
    {
        return $this->sound;
    }

    /**
     * @param EmbeddedFile $sound
     *
     * @return Sample
     */
    public function setSound(EmbeddedFile $sound): Sample
    {
        $this->sound = $sound;

        return $this;
    }
}