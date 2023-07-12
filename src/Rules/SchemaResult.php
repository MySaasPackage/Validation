<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\ValidatorResult;

class SchemaResult implements ValidatorResult
{
    public function __construct(
        protected readonly array $results = []
    ) {
    }

    public static function create(SchemaPropertyResult ...$results): self
    {
        return new self($results);
    }

    public static function failed(SchemaPropertyResult ...$results): self
    {
        return new self($results);
    }

    public static function succeeded(): self
    {
        return new self();
    }

    public function isSucceeded(): bool
    {
        return [] === $this->results;
    }

    public function isFailed(): bool
    {
        return [] !== $this->results;
    }

    public function getViolations(): array
    {
        return $this->results;
    }

    public function __toArray(): array
    {
        return array_reduce($this->results, static function (array $reduce, SchemaPropertyResult $result) {
            return array_merge($reduce, $result->__toArray());
        }, []);
    }
}
