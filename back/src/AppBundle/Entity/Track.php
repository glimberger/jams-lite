<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Track
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="track")
 * @ORM\Entity()
 */
final class Track
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