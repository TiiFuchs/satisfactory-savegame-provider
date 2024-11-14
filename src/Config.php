<?php

namespace Tii\SatisfactorySavegameProvider;

use Dotenv\Dotenv;

class Config
{
    public function __construct()
    {
        if (empty($_ENV)) {
            Dotenv::createImmutable(__DIR__.'/..')->load();
        }
    }

    public function get(string $var): mixed
    {
        return $_ENV[$var] ?? null;
    }
}