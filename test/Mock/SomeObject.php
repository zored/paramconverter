<?php


namespace Zored\ParamConverter\Test\Mock;


use JMS\Serializer\Annotation as Serializer;

class SomeObject
{
    /**
     * @Serializer\Type("integer")
     * @var int
     */
    public $inner;
}