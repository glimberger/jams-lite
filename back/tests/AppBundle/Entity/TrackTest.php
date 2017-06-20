<?php

namespace Test\AppBundle\Entity;

use AppBundle\Entity\Instrument;
use AppBundle\Entity\Track;
use PHPUnit\Framework\TestCase;

class TrackTest extends TestCase
{
    /**
     * @var Track
     */
    private $track;

    protected function setUp()
    {
        $this->track = new Track(1);
    }

    public function testGetId()
    {
        $this->assertEquals(1, $this->track->getId());
    }

    public function testGetInstrument()
    {
        $this->assertNull($this->track->getInstrument());
    }

    public function testSetInstrument()
    {
        $instrument = new Instrument(1, 'label');
        $obj = $this->track->setInstrument($instrument);

        $this->assertSame($obj, $this->track);
        $this->assertSame($instrument, $this->track->getInstrument());
    }
}
