<?php

namespace AppBundle\Domain\Jammer;


final class Roles
{
    public const USER = 'ROLE_USER';
    public const ADMIN = 'ROLE_ADMIN';

    public const ALL = [
        self::USER,
        self::ADMIN
    ];

    /**
     * Roles constructor.
     */
    private function __construct() { }
}