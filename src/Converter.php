<?php


namespace Zored\ParamConverter;


use Zored\ParamConverter\Deserializer\Deserializer;
use Zored\ParamConverter\Exception\ValidationException;
use Zored\ParamConverter\Parameter\Extractor\ExtractorInterface;
use Zored\ParamConverter\Parameter\Parameters;
use Zored\ParamConverter\Util\Util;

class Converter
{
    /**
     * @var Deserializer
     */
    private $deserializer;

    /**
     * @var ExtractorInterface
     */
    private $extractor;

    /**
     * @param Deserializer            $deserializer
     * @param ExtractorInterface|null $extractor
     */
    public function __construct(Deserializer $deserializer, ExtractorInterface $extractor = null)
    {
        $this->deserializer = $deserializer;
        $this->extractor = $extractor;
    }

    /**
     * @param array      $values Associative array with parameters.
     * @param Parameters $parameters Paramaters metadata.
     * @param bool       $associative
     * @return \mixed[]
     */
    public function convert(array $values, Parameters $parameters, bool $associative = false)
    {
        $result = [];

        // Required parameters are not covered:
        if ($associative && array_diff($parameters->getRequiredNames(), array_keys($values)) ||
            !$associative && $parameters->getRequiredCount() > count($values)
        ) {
            throw new ValidationException();
        }

        foreach ($parameters->getAll() as $parameter) {
            // Get deserialized value or default one:
            $valueIndex = $associative ? $parameter->getName() : $parameter->getIndex();
            $result[$parameter->getIndex()] = isset($values[$valueIndex])
                ? ($parameter->getClass()
                    ? $this->deserializer->deserialize($values[$valueIndex], $parameter->getClass())
                    : $values[$valueIndex]
                )
                : $parameter->getDefaultValue();
        }

        return $result;
    }

    /**
     * @param callable           $callable
     * @param array              $values
     * @param bool               $associative
     * @param ExtractorInterface $extractor
     * @return mixed
     */
    public function apply(callable $callable, array $values, bool $associative = false, ExtractorInterface $extractor = null)
    {
        $extractor = $extractor ?: $this->extractor;
        $values = $this->convert($values, $extractor->extract($callable), $associative);

        return call_user_func_array($callable, $values);
    }
}