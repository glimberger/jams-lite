<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class SoundFile
 * @package AppBundle\Entity
 *
 * @ORM\Embeddable()
 */
final class Sound
{
    /**
     * @var null|string
     *
     * @ORM\Column(type="string", name="name", nullable=true, options={"comment":"Path name of the sound file"})
     */
    private $name;

    /**
     * @var null|string
     *
     * @ORM\Column(type="string", name="original_name", nullable=true)
     */
    private $originalName;

    /**
     * @var \string[]
     *
     * @ORM\Column(type="array", name="mime_type")
     */
    private $mimeType;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", name="size")
     */
    private $size;

    /**
     * Sound constructor.
     * @param null|string $name
     * @param null|string $originalName
     * @param \string[]   $mimeType
     * @param int         $size
     */
    public function __construct(?string $name, ?string $originalName, array $mimeType = [], $size = 0)
    {
        $this->name = $name;
        $this->originalName = $originalName;
        $this->mimeType = $mimeType;
        $this->size = $size;
    }

    /**
     * @param null|string $name
     * @param null|string $originalName
     * @param array       $mimeType
     * @param int         $size
     * @return Sound
     */
    public static function create(?string $name, ?string $originalName, array $mimeType = [], $size = 0): Sound
    {
        return new self($name, $originalName, $mimeType, $size);
    }

    /**
     * @param UploadedFile $file
     * @return Sound
     */
    public static function createFromUploadedFile(UploadedFile $file): Sound
    {
        return new self($file->getFilename(), $file->getClientOriginalName(), [$file->getMimeType()], $file->getSize());
    }

    /**
     * @param File   $file
     * @param string $originalName
     * @return Sound
     */
    public static function createFromFile(File $file, string $originalName): Sound
    {
        return new self($file->getPathname(), $originalName, [$file->getMimeType()], $file->getSize());
    }

    /**
     * @param Sound $sound
     * @return Sound
     */
    public static function createFromSound(Sound $sound): Sound
    {
        return self::create($sound->getName(), $sound->getOriginalName(), $sound->getMimeType(), $sound->getSize());
    }

    /**
     * @return null|string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param null|string $name
     * @return Sound
     */
    public function setName($name): Sound
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getOriginalName(): ?string
    {
        return $this->originalName;
    }

    /**
     * @param null|string $originalName
     * @return Sound
     */
    public function setOriginalName($originalName): Sound
    {
        $this->originalName = $originalName;

        return $this;
    }

    /**
     * @return \string[]
     */
    public function getMimeType(): array
    {
        return $this->mimeType;
    }

    /**
     * @param \string[] $mimeType
     * @return Sound
     */
    public function setMimeType(array $mimeType): Sound
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    /**
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return Sound
     */
    public function setSize(int $size): Sound
    {
        $this->size = $size;

        return $this;
    }
}