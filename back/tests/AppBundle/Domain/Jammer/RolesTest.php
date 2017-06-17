<?php

namespace Test\AppBundle\Domain\Jammer;

use AppBundle\Domain\Jammer\Roles;
use PHPUnit\Framework\TestCase;

class RolesTest extends TestCase
{
    public function testAll()
    {
        $roles = ['ROLE_USER', 'ROLE_ADMIN'];

        $this->assertSame($roles, Roles::ALL);
    }
}
