<?php

namespace Varspool\PygmentsBundle\Cache;


class FilesystemCache implements CacheInterface
{
    protected $directory;


    public function __construct($directory)
    {
        $this->directory = $directory;

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }
    }

    public function get($key)
    {
        if (!$this->exists($key)) {
            return \RuntimeException(sprintf('The key "%s" does not exist in the cache directory ("%s").', $key, $this->directory));
        }

        return file_get_contents($this->getFilename($key));
    }

    public function set($key, $value)
    {
        return file_put_contents($this->getFilename($key), $value);
    }

    public function exists($key)
    {
        return file_exists($this->getFilename($key));
    }

    protected function getFilename($key)
    {
        return sprintf('%s/%s', $this->directory, $key);
    }
}
