<?php

namespace Test\AppBundle\Entity;

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
}
