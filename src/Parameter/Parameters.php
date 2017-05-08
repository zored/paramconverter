<?php


namespace Zored\ParamConverter\Parameter;


class Parameters
{
    /**
     * @var Parameter[]
     */
    private $all;

    /**
     * @param Parameter[] $all
     */
    public function __construct(array $all = [])
    {
        $this->all = $all;
    }

    /**
     * @return Parameter[]
     */
    public function getAll(): array
    {
        return $this->all;
    }

    public function getRequiredCount(): int
    {
        $count = 0;
        foreach ($this->all as $parameter) {
            if ($parameter->isRequired()) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * @return string[]|int[]
     */
    public function getRequiredNames(): array
    {
        $names = [];
        foreach ($this->all as $parameter) {
            if ($parameter->isRequired()) {
                $names[] = $parameter->getName();
            }
        }
        return $names;

    }
}