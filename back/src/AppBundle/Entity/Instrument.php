<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

final class Instrument
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
     *
     * @ORM\Column(type="string", name="label")
     */
    private $label;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Mapping")
     * @ORM\JoinTable(
     *     name="instrument_mappings",
     *     joinColumns={@ORM\JoinColumn(name="instrument_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="mapping_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $mappings;

    /**
     * Instrument constructor.
     *
     * @param int    $id
     * @param string $label
     */
    public function __construct(int $id, string $label)
    {
        $this->id = $id;
        $this->label = $label;
        $this->mappings = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     *
     * @return Instrument
     */
    public function setLabel(string $label): Instrument
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getMappings(): Collection
    {
        return $this->mappings;
    }

    /**
     * @param Mapping[] $mappings
     *
     * @return Instrument
     */
    public function setMappings(array $mappings): Instrument
    {
        $this->mappings = new ArrayCollection($mappings);

        return $this;
    }

    /**
     * @param Mapping $mapping
     *
     * @return Instrument
     */
    public function addMapping(Mapping $mapping): Instrument
    {
        if (!$this->mappings->contains($mapping)) {
            $this->mappings->add($mapping);
        }

        return $this;
    }

    /**
     * @param Mapping $mapping
     *
     * @return Instrument
     */
    public function removeMapping(Mapping $mapping): Instrument
    {
        if ($this->mappings->contains($mapping)) {
            $this->mappings->removeElement($mapping);
        }

        return $this;
    }
}