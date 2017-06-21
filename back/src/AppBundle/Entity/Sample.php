<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
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
     * @param int $id
     */
    public function __construct(?int $id)
    {
        $this->id = $id;
        $this->sound = new EmbeddedFile();
    }

    /**
     * @return int
     */
    public function getId(): ?int
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