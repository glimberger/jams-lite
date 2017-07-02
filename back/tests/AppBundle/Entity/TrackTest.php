<?php

namespace Test\AppBundle\Entity;

use AppBundle\Entity\Instrument;
use AppBundle\Entity\Track;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class TrackTest extends TestCase
{
    /**
     * @var Track
     */
    private $track;

    /**
     * @var Uuid
     */
    private $uuid;

    protected function setUp()
    {
        $this->uuid = Uuid::uuid4();
        $this->track = new Track($this->uuid);
    }

    public function testGetId()
    {
        $this->assertEquals($this->uuid, $this->track->getId());
    }

    public function testGetInstrument()
    {
        $this->assertNull($this->track->getInstrument());
    }

    public function testSetInstrument()
    {
        $instrument = new Instrument(Uuid::uuid4(), 'label');
        $obj = $this->track->setInstrument($instrument);

        $this->assertSame($obj, $this->track);
        $this->assertSame($instrument, $this->track->getInstrument());
    }
}
