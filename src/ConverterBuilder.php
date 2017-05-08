<?php


namespace Zored\ParamConverter;


use JMS\Serializer\Naming\CamelCaseNamingStrategy;
use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Zored\ParamConverter\Deserializer\Deserializer;
use Zored\ParamConverter\Deserializer\JMS\ArrayVisitor;
use Zored\ParamConverter\Parameter\Extractor\CacheExtractor;
use Zored\ParamConverter\Parameter\Extractor\ExtractorInterface;
use Zored\ParamConverter\Parameter\Extractor\MethodExtractor;

class ConverterBuilder
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * @var ExtractorInterface
     */
    private $extractor;

    /**
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer = null, ExtractorInterface $extractor = null)
    {
        $this->serializer = $serializer;
        $this->extractor = $extractor;
    }

    public static function create(): ConverterBuilder
    {
        return new self();
    }


    public function build()
    {
        $serializer = $this->serializer ?: $this->createDefaultSerializer();
        $deserializer = new Deserializer($serializer);
        $extractor = $this->extractor ?: $this->createExtractor();

        return new Converter($deserializer, $extractor);
    }

    /**
     * @param SerializerInterface $serializer
     * @return ConverterBuilder
     */
    public function setSerializer(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        return $this;
    }

    /**
     * @param ExtractorInterface $extractor
     * @return ConverterBuilder
     */
    public function setExtractor(ExtractorInterface $extractor)
    {
        $this->extractor = $extractor;
        return $this;
    }

    /**
     * @return Serializer
     */
    private function createDefaultSerializer(): Serializer
    {
        return SerializerBuilder::create()
            ->setDeserializationVisitor('array', new ArrayVisitor(new CamelCaseNamingStrategy()))
            ->build();
    }

    private function createExtractor(): ExtractorInterface
    {
        // Main extractor:
        $extractor = new MethodExtractor();

        // Cache example:
        return new CacheExtractor(new ArrayAdapter(), $extractor);
    }
}