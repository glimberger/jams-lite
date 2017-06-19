<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Sample;
use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    /**
     * @var Sample
     */
    private $sample;

    protected function setUp()
    {
        $this->sample = new Sample(1);
    }

    public function testGetId()
    {
        $this->assertEquals(1 , $this->sample->getId());
    }
}
