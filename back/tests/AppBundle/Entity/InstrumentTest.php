<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Instrument;
use AppBundle\Entity\Mapping;
use AppBundle\Entity\Sample;
use PHPUnit\Framework\TestCase;

class InstrumentTest extends TestCase
{
    /**
     * @var Instrument
     */
    private $instrument;

    /**
     * @var Mapping
     */
    private $mapping;

    protected function setUp()
    {
        $this->mapping = new Mapping(1, ['C1', 'C1'], new Sample(1));
        $this->instrument = new Instrument(1, 'label');
        $this->instrument->addMapping($this->mapping);
    }

    public function testGetId()
    {
        $this->assertEquals(1, $this->instrument->getId());
    }

    public function testGetLabel()
    {
        $this->assertEquals('label', $this->instrument->getLabel());
    }

    public function testSetLabel()
    {
        $obj = $this->instrument->setLabel('another_label');

        $this->assertSame($obj, $this->instrument);
        $this->assertEquals('another_label', $this->instrument->getLabel());
    }

    public function testAddMapping()
    {
        $this->assertCount(1, $this->instrument->getMappings());

        $mapping = new Mapping(1, ['C2', 'C2'], new Sample(2));
        $obj = $this->instrument->addMapping($mapping);

        $this->assertSame($obj, $this->instrument);
        $this->assertCount(2, $this->instrument->getMappings());
    }

    public function testAddMappingAgain()
    {
        $this->assertCount(1, $this->instrument->getMappings());

        $obj = $this->instrument->addMapping($this->mapping);

        $this->assertSame($obj, $this->instrument);
        $this->assertCount(1, $this->instrument->getMappings());
    }

    public function testRemoveMapping()
    {
        $this->assertCount(1, $this->instrument->getMappings());

        $obj = $this->instrument->removeMapping($this->mapping);

        $this->assertSame($obj, $this->instrument);
        $this->assertCount(0, $this->instrument->getMappings());
    }

    public function testRemoveMappingAgain()
    {
        $mapping = new Mapping(1, ['C2', 'C2'], new Sample(2));
        $this->instrument->addMapping($mapping);

        $this->assertCount(2, $this->instrument->getMappings());

        $this->instrument->removeMapping($mapping);

        $this->assertCount(1, $this->instrument->getMappings());

        $this->instrument->removeMapping($mapping);

        $this->assertCount(1, $this->instrument->getMappings());
    }
}
