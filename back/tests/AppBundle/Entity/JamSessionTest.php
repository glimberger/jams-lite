<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Jammer;
use AppBundle\Entity\JamSession;
use AppBundle\Entity\Track;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class JamSessionTest extends TestCase
{
    /**
     * @var JamSession
     */
    private $session;

    /**
     * @var Uuid
     */
    private $jammerUuid;

    /**
     * @var Uuid
     */
    private $sessionUuid;

    protected function setUp()
    {
        $this->jammerUuid = Uuid::uuid4();
        $jammer = new Jammer($this->jammerUuid, 'jammer@example.com', 'jammer');

        $this->sessionUuid = Uuid::uuid4();
        $this->session = new JamSession($this->sessionUuid, $jammer, 120, 'Jam session');
    }

    public function testNullId()
    {
        $this->assertEquals($this->sessionUuid, $this->session->getId());
    }

    public function testGetTempo()
    {
        $this->assertEquals(120, $this->session->getTempo());
    }

    public function testSetTempo()
    {
        $obj = $this->session->setTempo(240);

        $this->assertSame($obj, $this->session);
        $this->assertEquals(240, $this->session->getTempo());
    }

    public function testGetLabel()
    {
        $this->assertEquals('Jam session', $this->session->getLabel());
    }

    public function testSetLabel()
    {
        $obj = $this->session->setLabel('label');

        $this->assertSame($obj, $this->session);
        $this->assertEquals('label', $this->session->getLabel());
    }

    public function testGetOwner()
    {
        $this->assertInstanceOf(Jammer::class, $this->session->getOwner());
        $this->assertEquals($this->jammerUuid, $this->session->getOwner()->getId());
        $this->assertEquals('jammer@example.com', $this->session->getOwner()->getUsername());
        $this->assertEquals('jammer', $this->session->getOwner()->getAlias());
    }

    public function testNullDescription()
    {
        $this->assertNull($this->session->getDescription());
    }

    public function testSetDescription()
    {
        $obj = $this->session->setDescription('text');

        $this->assertSame($obj, $this->session);
        $this->assertSame('text', $this->session->getDescription());
    }

    public function testEmptyTrackCollection()
    {
        $this->assertTrue($this->session->getTracks()->isEmpty());
    }

    public function testAddTrack()
    {
        $track1 = $this->createMock(Track::class);
        $track2 = $this->createMock(Track::class);
        $obj = $this->session->addTrack($track1)->addTrack($track2);

        $this->assertSame($obj, $this->session);
        $this->assertCount(2, $this->session->getTracks());
        $this->assertContains($track1, $this->session->getTracks()->toArray());
        $this->assertContains($track2, $this->session->getTracks()->toArray());
    }

    public function testAddTrackTwice()
    {
        $track = $this->createMock(Track::class);
        $obj = $this->session->addTrack($track);

        $this->assertSame($obj, $this->session);
        $this->assertCount(1, $this->session->getTracks());
        $this->assertContains($track, $this->session->getTracks()->toArray());

        $this->session->addTrack($track);
        $this->assertCount(1, $this->session->getTracks());
    }

    public function testRemoveTrack()
    {
        $track1 = $this->createMock(Track::class);
        $track2 = $this->createMock(Track::class);
        $this->session->addTrack($track1)->addTrack($track2);

        $this->assertCount(2, $this->session->getTracks());

        $obj = $this->session->removeTrack($track2);

        $this->assertSame($obj, $this->session);
        $this->assertCount(1, $this->session->getTracks());
        $this->assertContains($track1, $this->session->getTracks()->toArray());
        $this->assertNotContains($track2, $this->session->getTracks()->toArray());
    }

    public function testRemoveUnknownTrack()
    {
        $track1 = $this->createMock(Track::class);
        $track2 = $this->createMock(Track::class);
        $this->session->addTrack($track1);

        $obj = $this->session->removeTrack($track2);

        $this->assertSame($obj, $this->session);
        $this->assertCount(1, $this->session->getTracks());
        $this->assertContains($track1, $this->session->getTracks()->toArray());
    }

    public function testRemoveTrackTwice()
    {
        $track1 = $this->createMock(Track::class);
        $track2 = $this->createMock(Track::class);
        $this->session->addTrack($track1)->addTrack($track2);

        $this->assertCount(2, $this->session->getTracks());

        $obj = $this->session->removeTrack($track2);

        $this->assertSame($obj, $this->session);
        $this->assertCount(1, $this->session->getTracks());
        $this->assertNotContains($track2, $this->session->getTracks()->toArray());

        $this->session->removeTrack($track2);

        $this->assertCount(1, $this->session->getTracks());
    }
}
