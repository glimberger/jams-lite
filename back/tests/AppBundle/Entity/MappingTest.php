<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Mapping;
use AppBundle\Entity\Range;
use AppBundle\Entity\Sample;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

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

    /**
     * @var Uuid
     */
    private $uuid;

    protected function setUp()
    {
        $this->sample = $this->createMock(Sample::class);
        $this->uuid = Uuid::uuid4();
        $this->mapping = new Mapping($this->uuid, ['C1', 'D2'], $this->sample);
    }

    public function testGetId()
    {
        $this->assertEquals($this->uuid, $this->mapping->getId());
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
        $sample = $this->createMock(Sample::class);
        $obj = $this->mapping->setSample($sample);

        $this->assertSame($obj, $this->mapping);
        $this->assertSame($sample, $this->mapping->getSample());
    }
}
