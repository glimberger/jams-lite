<?php
declare(strict_types=1);

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * Class Session
 *
 * @package AppBundle\Entity
 *
 * @ORM\Table(name="session")
 * @ORM\Entity()
 */
class JamSession
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
     *     nullable=true,
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
     *     referencedColumnName="id"
     * )
     */
    private $owner;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Track")
     * @ORM\JoinTable(
     *     name="session_tracks",
     *     joinColumns={@ORM\JoinColumn(name="session_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="track_id", referencedColumnName="id", unique=true)}
     * )
     */
    private $tracks;

    /**
     * Session constructor.
     *
     * @param UuidInterface $id
     * @param Jammer        $owner
     * @param string        $tempo
     * @param string        $label
     */
    public function __construct(UuidInterface $id, Jammer $owner, $tempo, $label)
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->tempo = $tempo;
        $this->label = $label;
        $this->tracks = new ArrayCollection();
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
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
     * @return null|string
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

    /**
     * @return Collection
     */
    public function getTracks(): Collection
    {
        return $this->tracks;
    }

    /**
     * @param array $tracks
     *
     * @return JamSession
     */
    public function setTracks(array $tracks): JamSession
    {
        $this->tracks = new ArrayCollection($tracks);

        return $this;
    }

    public function addTrack(Track $track): JamSession
    {
        if (!$this->tracks->contains($track)) {
            $this->tracks[] = $track;
        }

        return $this;
    }

    /**
     * @param Track $track
     *
     * @return JamSession
     */
    public function removeTrack(Track $track): JamSession
    {
        if ($this->tracks->contains($track)) {
            $this->tracks->removeElement($track);
        }

        return $this;
    }
}