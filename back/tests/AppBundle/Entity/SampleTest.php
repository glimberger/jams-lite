<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Sample;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SampleTest extends TestCase
{
    public function testGetId()
    {
        $uuid = Uuid::uuid4();
        $sample = new Sample($uuid);

        $this->assertEquals($uuid , $sample->getId());
    }
}
