<?php

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Jammer;
use PHPUnit\Framework\TestCase;

class JammerTest extends TestCase
{
    /**
     * @var Jammer
     */
    private $jammer;

    protected function setUp()
    {
        $this->jammer = new Jammer('user@example.com', 'alias');
    }

    public function testGetSalt()
    {
        $this->assertNotNull($this->jammer->getSalt());
    }

    public function testSetSalt()
    {
        $obj = $this->jammer->setSalt('salt');

        $this->assertSame($obj, $this->jammer);
        $this->assertSame('salt', $this->jammer->getSalt());
    }

    public function testIsAccountNonExpired()
    {
        $this->assertTrue($this->jammer->isAccountNonExpired());
    }

    public function testSetAccountNonExpired()
    {
        $obj = $this->jammer->setAccountExpired(true);

        $this->assertSame($obj, $this->jammer);
        $this->assertFalse($this->jammer->isAccountNonExpired());
    }

    public function testIsAccountNonLocked()
    {
        $this->assertTrue($this->jammer->isAccountNonLocked());
    }

    public function testLockAccount()
    {
        $obj = $this->jammer->lockAccount();

        $this->assertSame($obj, $this->jammer);
        $this->assertFalse($this->jammer->isAccountNonLocked());
    }

    public function testUnlockAccount()
    {
        $obj = $this->jammer->lockAccount()->unlockAccount();

        $this->assertSame($obj, $this->jammer);
        $this->assertTrue($this->jammer->isAccountNonLocked());
    }

    public function testIsCredentialsNonExpired()
    {
        $this->assertTrue($this->jammer->isCredentialsNonExpired());
    }

    public function testIsEnabled()
    {
        $this->assertFalse($this->jammer->isEnabled());
    }

    public function testEnable()
    {
        $obj = $this->jammer->enable();

        $this->assertSame($obj, $this->jammer);
        $this->assertTrue($this->jammer->isEnabled());
    }

    public function testDisable()
    {
        $obj = $this->jammer->enable()->disable();

        $this->assertSame($obj, $this->jammer);
        $this->assertFalse($this->jammer->isEnabled());
    }

    public function testGetUsername()
    {
        $this->assertSame('user@example.com', $this->jammer->getUsername());
    }

    public function testSetUsername()
    {
        $obj = $this->jammer->setUsername('other@example.com');

        $this->assertSame($obj, $this->jammer);
        $this->assertSame('other@example.com', $this->jammer->getUsername());
    }

    public function testGetAlias()
    {
        $this->assertSame('alias', $this->jammer->getAlias());
    }

    public function testSetAlias()
    {
       $obj = $this->jammer->setAlias('other_alias');

       $this->assertSame($obj, $this->jammer);
       $this->assertSame('other_alias', $this->jammer->getAlias());
    }

    public function testGetPassword()
    {
        $this->assertNull($this->jammer->getPassword());
    }

    public function testSetPassword()
    {
        $obj = $this->jammer->setPassword('dsdfsdkljf');

        $this->assertSame($obj, $this->jammer);
        $this->assertSame('dsdfsdkljf', $this->jammer->getPassword());
    }

    public function testGetPlainPassword()
    {
        $this->assertNull($this->jammer->getPlainPassword());
    }

    public function testSetPlainPassword()
    {
        $obj = $this->jammer->setPlainPassword('plain_pwd');

        $this->assertSame($obj, $this->jammer);
        $this->assertSame('plain_pwd', $this->jammer->getPlainPassword());
    }

    public function testEraseCredentials()
    {
        $this->jammer->setPlainPassword('password');
        $obj = $this->jammer->eraseCredentials();

        $this->assertSame($obj, $this->jammer);
        $this->assertNull($this->jammer->getPassword());
    }
}
