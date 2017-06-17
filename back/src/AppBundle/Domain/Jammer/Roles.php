<?php

namespace AppBundle\Domain\Jammer;


class Roles
{
    const USER = 'ROLE_USER';
    const ADMIN = 'ROLE_ADMIN';

    const ALL = [
        self::USER,
        self::ADMIN
    ];

    /**
     * Roles constructor.
     */
    private function __construct() { }
}