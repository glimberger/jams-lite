<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Track
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="track")
 * @ORM\Entity()
 */
class Track
{
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
     * @var Instrument
     *
     * @ORM\ManyToOne(targetEntity="Instrument")
     * @ORM\JoinColumn(name="instrument_id", referencedColumnName="id")
     */
    private $instrument;

    /**
     * Track constructor.
     *
     * @param UuidInterface $id
     */
    public function __construct(UuidInterface $id)
    {
        $this->id = $id;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return Instrument
     */
    public function getInstrument(): ?Instrument
    {
        return $this->instrument;
    }

    /**
     * @param Instrument $instrument
     *
     * @return Track
     */
    public function setInstrument(Instrument $instrument): Track
    {
        $this->instrument = $instrument;

        return $this;
    }
}