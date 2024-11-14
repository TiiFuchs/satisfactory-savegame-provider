<?php

namespace Tii\SatisfactorySaveGame;

use Dotenv\Dotenv;

class Config
{
    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__.'/..');
        $dotenv->load();
    }

    public function get(string $var): mixed
    {
        return $_ENV[$var] ?? null;
    }
}