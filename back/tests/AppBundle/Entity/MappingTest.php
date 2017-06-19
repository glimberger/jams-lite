<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Mapping;
use AppBundle\Entity\Range;
use AppBundle\Entity\Sample;
use PHPUnit\Framework\TestCase;

class MappingTest extends TestCase
{
    /**
     * @var Mapping
     */
    private $mapping;

    /**
     * @var Sample
     */
    private $sample;

    protected function setUp()
    {
        $this->sample = new Sample(1);
        $this->mapping = new Mapping(1, ['C1', 'D2'], $this->sample);
    }

    public function testGetId()
    {
        $this->assertEquals(1, $this->mapping->getId());
    }

    public function testGetRange()
    {
        $range = $this->mapping->getRange();

        $this->assertEquals('C1', $range->getLowerLimit());
        $this->assertEquals('D2', $range->getUpperLimit());
    }

    public function testGetLowerLimit()
    {
        $this->assertEquals('C1', $this->mapping->getLowerLimit());
    }

    public function testGetUpperLimit()
    {
        $this->assertEquals('D2', $this->mapping->getUpperLimit());
    }

    public function testSetRange()
    {
        $range = (Range::create(['C3', 'E3']));
        $obj = $this->mapping->setRange(Range::create(['C3', 'E3']));

        $this->assertSame($obj, $this->mapping);
        $this->assertEquals($range->getLowerLimit(), $this->mapping->getRange()->getLowerLimit());
        $this->assertEquals($range->getUpperLimit(), $this->mapping->getRange()->getUpperLimit());
    }

    public function testGetSample()
    {
        $this->assertSame($this->sample, $this->mapping->getSample());
    }

    public function testSetSample()
    {
        $sample = new Sample(2);
        $obj = $this->mapping->setSample($sample);

        $this->assertSame($obj, $this->mapping);
        $this->assertSame($sample, $this->mapping->getSample());
    }
}
