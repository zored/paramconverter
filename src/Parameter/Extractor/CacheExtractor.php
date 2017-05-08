<?php


namespace Zored\ParamConverter\Parameter\Extractor;


use Psr\Cache\CacheItemPoolInterface;
use Zored\ParamConverter\Exception\CallableException;
use Zored\ParamConverter\Parameter\Parameters;

class CacheExtractor implements ExtractorInterface
{
    /**
     * @var CacheItemPoolInterface
     */
    private $cache;

    /**
     * @var ExtractorInterface
     */
    private $delegate;

    public function __construct(CacheItemPoolInterface $cache, ExtractorInterface $delegate)
    {
        $this->cache = $cache;
        $this->delegate = $delegate;
    }
    /**
     * {@inheritDoc}
     */
    public function extract(callable $callable): Parameters
    {
        $key = $this->getCacheKey($callable);
        $key = md5($key);
        $item = $this->cache->getItem($key);
        if ($item->isHit()) {
            return $item->get();
        }
        $parameters = $this->delegate->extract($callable);
        $item->set($parameters);
        $this->cache->save($item);
        return $parameters;
    }

    /**
     * Get cache key for callable.
     *
     * @param callable $callable
     * @return callable|string
     */
    private function getCacheKey(callable $callable)
    {
        if (is_string($callable)) {
            return $callable;
        }

        if (is_array($callable)) {
            if (!is_string($callable[0])) {
                $callable[0] = get_class($callable[0]);
            }
            return implode('::', $callable);
        }

        throw new CallableException();
    }
}