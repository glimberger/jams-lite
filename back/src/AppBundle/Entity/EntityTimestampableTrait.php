<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Add timestamp behaviour to a Doctrine entity.
 *
 * Also supports lifecycle callbacks for pre persist and pre update events.
 *
 * @package Ifa\Bundle\DivaBundle\Entity\Traits
 */
trait EntityTimestampableTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\PrePersist
     */
    public function setCreateValue(): void
    {
        $this->setCreatedAt();
        $this->setUpdatedAt();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdateValue(): void
    {
        $this->setUpdatedAt();
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt(?\DateTime $createdAt = null)
    {
        if (null == $createdAt) {
            $this->createdAt = new \DateTimeImmutable();
        }
        else {
            $this->createdAt = $createdAt;
        }

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt(?\DateTime $updatedAt = null)
    {
        if (null == $updatedAt) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        else {
            $this->updatedAt = $updatedAt;
        }


        return $this;
    }
}