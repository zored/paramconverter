<?php


namespace Zored\ParamConverter\Deserializer;


use JMS\Serializer\SerializerInterface;

class Deserializer
{
    /**
     * @var SerializerInterface
     */
    protected $serializer;

    /**
     * Deserializer constructor.
     * @param SerializerInterface $serializer
     */
    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }


    /**
     * @param             $value
     * @param string|null $type
     * @return mixed
     */
    public function deserialize($value, string $type)
    {
        return $this->serializer->deserialize($value, $type, 'array');
    }
}