<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
     * @var string
     */
    private $soundName;

    /**
     * @var string
     */
    private $soundOriginalName;

    /**
     * @var int
     */
    private $soundSize;

    /**
     * @var UploadedFile
     */
    private $soundFile;

    /**
     * Track constructor.
     *
     * @param int $id
     */
    public function __construct(?int $id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}