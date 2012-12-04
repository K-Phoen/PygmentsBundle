<?php

namespace Varspool\PygmentsBundle\Cache;

interface CacheInterface
{
    public function get($key);
    public function set($key, $value);
    public function exists($key);
}
