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
        'C0', 'C0#', 'D0', 'E0b', 'E0', 'F0', 'F0#', 'G0', 'G0#', 'A0', 'B0b', 'B0',
        'C1', 'C1#', 'D1', 'E1b', 'E1', 'F1', 'F1#', 'G1', 'G1#', 'A1', 'B1b', 'B1',
        'C2', 'C2#', 'D2', 'E2b', 'E2', 'F2', 'F2#', 'G2', 'G2#', 'A2', 'B2b', 'B2',
        'C3', 'C3#', 'D3', 'E3b', 'E3', 'F3', 'F3#', 'G3', 'G3#', 'A3', 'B3b', 'B3',
        'C4', 'C4#', 'D4', 'E4b', 'E4', 'F4', 'F4#', 'G4', 'G4#', 'A4', 'B4b', 'B4',
        'C5', 'C5#', 'D5', 'E5b', 'E5', 'F5', 'F5#', 'G5', 'G5#', 'A5', 'B5b', 'B5',
        'C6', 'C6#', 'D6', 'E6b', 'E6', 'F6', 'F6#', 'G6', 'G6#', 'A6', 'B6b', 'B6',
        'C7', 'C7#', 'D7', 'E7b', 'E7', 'F7', 'F7#', 'G7', 'G7#', 'A7', 'B7b', 'B7',
    ];

    /**
     * @var array
     *
     * @ORM\Column(type="json", name="range")
     */
    private $range;

    public static function create(array $range)
    {
        if (count($range) != 2) {
            throw new \InvalidArgumentException('Range should have two items');
        }

        self::checkValidity($range);

        return new self($range);
    }

    public static function createFromRange(Range $range)
    {
        return new self([$range->getLowerLimit(), $range->getUpperLimit()]);
    }

    private static function checkValidity(array $range)
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

    /**
     * Range constructor.
     *
     * @param array $range
     */
    private function __construct(array $range)
    {
        $values = [];

        list($lowerLimit, $upperLimit) = $range;
        $lowerIndex = array_search($lowerLimit, self::VALUES);
        $upperIndex = array_search($upperLimit, self::VALUES);

        for ($i = $lowerIndex; $i <= $upperIndex; $i++ ) {
            $values[] = self::VALUES[$i];
        }
        $this->range = $values;
    }

    public function getLowerLimit(): string
    {
        return reset($this->range);
    }


    public function getUpperLimit(): string
    {
        return end($this->range);
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        return $this->range;
    }
}