<?php


namespace Zored\ParamConverter\Parameter;


class Parameter
{
    /**
     * @var int
     */
    private $index;

    /**
     * @var string
     */
    private $name;

    /**
     * @var mixed
     */
    private $defaultValue;

    /**
     * @var string
     */
    private $class;

    /**
     * @var bool
     */
    private $required;

    /**
     * Parameter constructor.
     * @param int    $index
     * @param string $name
     * @param mixed  $defaultValue
     * @param string $class
     * @param bool   $required
     */
    public function __construct(int $index = null, string $name = null, $defaultValue = null, string $class = null, bool $required = null)
    {
        $this->index = $index;
        $this->name = $name;
        $this->defaultValue = $defaultValue;
        $this->class = $class;
        $this->required = $required;
    }


    public function getIndex(): int
    {
        return $this->index;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }

    public function getClass(): ?string
    {
        return $this->class;
    }

    /**
     * @return bool
     */
    public function isRequired(): bool
    {
        return $this->required;
    }
}