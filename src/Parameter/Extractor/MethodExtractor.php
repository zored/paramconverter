<?php


namespace Zored\ParamConverter\Parameter\Extractor;


use Zored\ParamConverter\Parameter\Parameter;
use Zored\ParamConverter\Parameter\Parameters;

class MethodExtractor implements ExtractorInterface
{
    /**
     * @param callable|array $callable
     * @return Parameters
     */
    public function extract(callable $callable): Parameters
    {
        list($entity, $method) = $callable;
        $parameters = [];
        foreach ($this->getMethod($entity, $method)->getParameters() as $parameter) {
            $parameters[] = $this->parseParameter($parameter);
        }

        return new Parameters($parameters);
    }

    /**
     * @param $entity
     * @param string $method
     * @return \ReflectionMethod
     */
    protected function getMethod($entity, string $method): \ReflectionMethod
    {
        $class = is_string($entity)
            ? $entity
            : get_class($entity);
        $method = new \ReflectionMethod($class, $method);
        return $method;
    }

    /**
     * Turn reflection into regular parameter.
     *
     * @param \ReflectionParameter $parameter
     * @return Parameter
     */
    private function parseParameter(\ReflectionParameter $parameter): Parameter
    {
        return new Parameter(
            $parameter->getPosition(),
            $parameter->getName(),
            $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null,
            $parameter->getClass() ? $parameter->getClass()->getName() : null,
            !$parameter->isOptional()
        );
    }
}