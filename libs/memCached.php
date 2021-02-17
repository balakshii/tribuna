<?php
class MemcachedConnect
{
    private static $instance = null;
    private $memcache;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
        $this->memcache = new Memcache;
        $this->memcache->connect('127.0.0.1', 11211);
    }

    public function getConnect()
    {
        return $this->memcache;
    }
}