<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Jammer;
use AppBundle\Entity\JamSession;
use PHPUnit\Framework\TestCase;

class JamSessionTest extends TestCase
{
    /**
     * @var JamSession
     */
    private $session;

    protected function setUp()
    {
        $jammer = new Jammer(1,'jammer@example.com', 'jammer');
        $this->session = new JamSession(1, $jammer, 120, 'Jam session');
    }

    public function testNullId()
    {
        $this->assertEquals(1, $this->session->getId());
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
        $this->assertEquals(1, $this->session->getOwner()->getId());
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
}
