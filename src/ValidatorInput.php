<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

readonly class ValidatorInput
{
    protected array $input;

    public function __construct(object|array $input)
    {
        $this->input = (array) $input;
    }

    public function getOrNull(string $key): mixed
    {
        if (array_key_exists($key, $this->input)) {
            return $this->input[$key];
        }

        return null;
    }

    public function __toRaw(): mixed
    {
        return $this->input;
    }

    public function __toArray(): array
    {
        return $this->input;
    }
}
