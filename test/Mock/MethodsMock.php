<?php


namespace Zored\ParamConverter\Test\Mock;


class MethodsMock
{
    public function getArguments(
        SomeObject $typedValue,
        string $stringValue,
        int $intValue,
        $mixedValue,
        $defaultValue = 10
    ): array
    {
        return func_get_args();
    }
}