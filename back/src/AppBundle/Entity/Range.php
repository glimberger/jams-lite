<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Range
 *
 * @package AppBundle\Entity
 *
 * @ORM\Embeddable()
 */
final class Range
{
    const VALUES = [
        'C0', 'D0', 'E0', 'F0', 'G0', 'A0', 'B0',
        'C1', 'D1', 'E1', 'F1', 'G1', 'A1', 'B1',
        'C2', 'D2', 'E2', 'F2', 'G2', 'A2', 'B2',
        'C3', 'D3', 'E3', 'F3', 'G3', 'A3', 'B3',
        'C4', 'D4', 'E4', 'F4', 'G4', 'A4', 'B4',
        'C5', 'D5', 'E5', 'F5', 'G5', 'A5', 'B5',
        'C6', 'D6', 'E6', 'F6', 'G6', 'A6', 'B6',
        'C7', 'D7', 'E7', 'F7', 'G7', 'A7', 'B7',
    ];

    /**
     * @var array
     *
     * @ORM\Column(type="json", name="range")
     */
    private $range;

    public static function createFromRange(array $range)
    {
        if (count($range) != 2) {
            throw new \InvalidArgumentException('Range should have two items');
        }

        return new self($range);
    }

    public static function createFromValues(string $lowerLimit, string $upperLimit)
    {
        return new self([$lowerLimit, $upperLimit]);
    }

    /**
     * Range constructor.
     *
     * @param array $range
     */
    public function __construct(array $range)
    {
        $this->checkValidity($range);

        $this->range = $range;
    }

    private function checkValidity(array $range)
    {
        list($lowerLimit, $upperLimit) = $range;

        if (!in_array($lowerLimit, self::VALUES, true)) {
            throw new \InvalidArgumentException("Invalid note");
        }

        if (!in_array($upperLimit, self::VALUES, true)) {
            throw new \InvalidArgumentException("Invalid note");
        }

        if (array_search($lowerLimit, self::VALUES, true) > array_search($upperLimit, self::VALUES, true)) {
            throw new \InvalidArgumentException("Invalid range");
        }
    }

    public function getLowerLimit(): string
    {
        list($lowerLimit,) = $this->range;

        return $lowerLimit;
    }

    public function getUpperLimit(): string
    {
        list(,$upperLimit) = $this->range;

        return $upperLimit;
    }
}