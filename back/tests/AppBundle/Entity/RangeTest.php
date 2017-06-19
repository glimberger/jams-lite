<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Range;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    /**
     * @var Range
     */
    private $range;

    protected function setUp()
    {
        $this->range = new Range(['C1', 'D2']);
    }

    public function testCreateFromRange()
    {
        $range = Range::createFromRange(['C1', 'C2']);

        $this->assertEquals('C1', $range->getLowerLimit());
        $this->assertEquals('C2', $range->getUpperLimit());
    }

    public function testCreateFromValues()
    {
        $range = Range::createFromValues('C1', 'D1');

        $this->assertEquals('C1', $range->getLowerLimit());
        $this->assertEquals('D1', $range->getUpperLimit());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid note
     */
    public function testInvalidLowerLimit()
    {
        $range = Range::createFromValues('note', 'D1');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid note
     */
    public function testInvalidUpperLimit()
    {
        $range = Range::createFromValues('C1', 'note');
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid range
     */
    public function testInvalidRange()
    {
        $range = Range::createFromValues('C3', 'D1');
    }
}
