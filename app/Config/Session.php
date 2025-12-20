<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Session\Handlers\DatabaseHandler;

class Session extends BaseConfig
{
    public string $driver = DatabaseHandler::class;
    public string $cookieName = 'ci_session';
    public int $expiration = 7200;
    public string $savePath = 'ci_sessions'; // This is just the table name without prefix
    public bool $matchIP = false;
    public int $timeToUpdate = 3600;
    public bool $regenerateDestroy = false;
    public ?string $DBGroup = 'default';
    public int $lockRetryInterval = 100_000;
    public int $lockMaxRetries = 300;
}