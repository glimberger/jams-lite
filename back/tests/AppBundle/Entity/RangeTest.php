<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Range;
use PHPUnit\Framework\TestCase;

class RangeTest extends TestCase
{
    public function testCreate()
    {
        $range = Range::create(['C1', 'C2']);

        $this->assertEquals('C1', $range->getLowerLimit());
        $this->assertEquals('C2', $range->getUpperLimit());
    }

    public function testCreateFromRange()
    {
        $range = Range::createFromRange(Range::create(['C1', 'C2']));

        $this->assertEquals('C1', $range->getLowerLimit());
        $this->assertEquals('C2', $range->getUpperLimit());
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid note
     */
    public function testInvalidLowerLimit()
    {
        $range = Range::create(['note', 'D1']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid note
     */
    public function testInvalidUpperLimit()
    {
        $range = Range::create(['C1', 'note']);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Invalid range
     */
    public function testInvalidRange()
    {
        $range = Range::create(['C3', 'D1']);
    }
}
