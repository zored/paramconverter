<?php


namespace Zored\ParamConverter\Deserializer\JMS;


use JMS\Serializer\GenericDeserializationVisitor;

class ArrayVisitor extends GenericDeserializationVisitor
{
    /**
     * {@inheritDoc}
     */
    protected function decode($array)
    {
        return $array;
    }
}