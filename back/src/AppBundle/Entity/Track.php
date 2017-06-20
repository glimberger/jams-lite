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
     * @var Instrument
     *
     * @ORM\ManyToOne(targetEntity="Instrument")
     * @ORM\JoinColumn(name="instrument_id", referencedColumnName="id")
     */
    private $instrument;

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