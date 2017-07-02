<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Class InstrumentMapping
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="mapping")
 * @ORM\Entity()
 */
class Mapping
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
     * @var Range
     *
     * @ORM\Embedded(class="AppBundle\Entity\Range", columnPrefix=false)
     */
    private $range;

    /**
     * @var Sample
     *
     * @ORM\ManyToOne(targetEntity="Sample")
     * @ORM\JoinColumn(name="sample_id", referencedColumnName="id")
     */
    private $sample;

    /**
     * InstrumentMapping constructor.
     *
     * @param UuidInterface $id
     * @param array    $range
     * @param Sample   $sample
     */
    public function __construct(UuidInterface $id, array $range, Sample $sample)
    {
        $this->id = $id;
        $this->range = Range::create($range);
        $this->sample = $sample;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return Range
     */
    public function getRange(): Range
    {
        return $this->range;
    }

    /**
     * @param Range $range
     *
     * @return Mapping
     */
    public function setRange(Range $range): Mapping
    {
        $this->range = Range::createFromRange($range);

        return $this;
    }

    /**
     * @return string
     */
    public function getLowerLimit(): string
    {
        return $this->range->getLowerLimit();
    }

    /**
     * @return string
     */
    public function getUpperLimit(): string
    {
        return $this->range->getUpperLimit();
    }

    /**
     * @return Sample
     */
    public function getSample(): Sample
    {
        return $this->sample;
    }

    /**
     * @param Sample $sample
     *
     * @return Mapping
     */
    public function setSample(Sample $sample): Mapping
    {
        $this->sample = $sample;

        return $this;
    }
}