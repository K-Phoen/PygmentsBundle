<?php

namespace Varspool\PygmentsBundle\Twig;

use Varspool\PygmentsBundle\Cache\CacheInterface;


/**
 * This class contains the following Twig filters:
 *  * pygmentize($text, $language). Exemple usage {{ some_code|pygmentize('php') }}
 *
 * @author Kévin Gomez <contact@kevingomez.fr>
 */
class PygmentsExtension extends \Twig_Extension
{
    protected $pygments_renderer;
    protected $cache;


    public function __construct($pygments_renderer)
    {
        $this->pygments_renderer = $pygments_renderer;
    }

    public function useCache(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function getFilters()
    {
        return array(
            'pygmentize' => new \Twig_Filter_Method($this, 'pygmentize'),
        );
    }

    public function pygmentize($text, $language)
    {
        $key = md5($text);

        if ($this->cache !== null && $this->cache->exists($key)) {
            return $this->cache->get($key);
        }

        $rendered = $this->pygments_renderer->blockCode($text, $language);

        if ($this->cache !== null) {
            $this->cache->set($key, $rendered);
        }

        return $rendered;
    }

    public function getName()
    {
        return 'pygments_extension';
    }
}

