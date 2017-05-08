<?php


namespace Zored\ParamConverter\Parameter\Extractor;


use Zored\ParamConverter\Parameter\Parameters;

interface ExtractorInterface
{
    public function extract(callable $callable): Parameters;
}