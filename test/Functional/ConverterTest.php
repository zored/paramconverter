<?php


namespace Zored\ParamConverter\Test\Functional;

use PHPUnit\Framework\TestCase;
use Zored\ParamConverter\ConverterBuilder;
use Zored\ParamConverter\Test\Mock\MethodsMock;
use Zored\ParamConverter\Test\Mock\SomeObject;

class ConverterTest extends TestCase
{
    /**
     * @dataProvider dataApply
     * @param array $data
     * @param bool  $associative
     */
    public function testApply(array $data, bool $associative)
    {
        $converter = ConverterBuilder::create()->build();
        $result = $converter->apply([new MethodsMock(), 'getArguments'], $data, $associative);
        $this->assertInstanceOf(SomeObject::class, $result[0]);
        $this->assertSame(123, $result[0]->inner);
    }

    public function dataApply()
    {
        return [
            [
                'data' => [
                    'typedValue' => [
                        'inner' => 123
                    ],
                    'stringValue' => 'abc',
                    'intValue' => 456,
                    'mixedValue' => 'mixed',
                ],
                'associative' => true
            ],
            [
                'data' => [
                    ['inner' => 123],
                    'abc',
                    456,
                    'mixed',
                    'som'
                ],
                'associative' => false
            ],
        ];
    }
}