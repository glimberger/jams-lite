<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Session
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="session")
 * @ORM\Entity()
 */
final class JamSession
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
     * @var int
     *
     * @ORM\Column(
     *     type="smallint",
     *     name="tempo",
     *     options={"comment": "tempo of the session in BPM"}
     * )
     */
    private $tempo;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     name="label",
     *     options={"comment": "the session label"}
     * )
     */
    private $label;

    /**
     * @var string
     *
     * @ORM\Column(
     *     type="text",
     *     name="description",
     *     nullable=true
     *     options={"comment": "a exhaustive description of the session"}
     * )
     */
    private $description;

    /**
     * @var Jammer
     *
     * @ORM\ManyToOne(
     *     targetEntity="Jammer",
     *     inversedBy="sessions"
     * )
     * @ORM\JoinColumn(
     *     name="jammer_id",
     *     referencedColumnName="id",
     *     options={"comment": "the jammer owner ID"}
     * )
     */
    private $owner;

    /**
     * Session constructor.
     *
     * @param int|null $id
     * @param Jammer   $owner
     * @param string   $tempo
     * @param string   $label
     */
    public function __construct(?int $id, Jammer $owner, $tempo, $label)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->tempo = $tempo;
        $this->label = $label;
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
    public function getTempo(): string
    {
        return $this->tempo;
    }

    /**
     * @param string $tempo
     *
     * @return JamSession
     */
    public function setTempo(string $tempo): JamSession
    {
        $this->tempo = $tempo;

        return $this;
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
     * @return JamSession
     */
    public function setLabel(string $label): JamSession
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     *
     * @return JamSession
     */
    public function setDescription(string $description): JamSession
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Jammer
     */
    public function getOwner(): Jammer
    {
        return $this->owner;
    }

    /**
     * @param Jammer $owner
     *
     * @return JamSession
     */
    public function setOwner(Jammer $owner): JamSession
    {
        $this->owner = $owner;

        return $this;
    }
}