<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Violations;

use MySaasPackage\Validation\Violation;

class FieldViolation implements Violation
{
    protected Violation|null $sibling = null;

    public function __construct(
        public readonly string $field,
        public readonly Violation $violation
    ) {
    }

    public function getSibling(): Violation|null
    {
        return $this->sibling;
    }

    public function hasSibling(): bool
    {
        return null !== $this->sibling;
    }

    public function addSibling(Violation $sibling): Violation
    {
        if ($this->hasSibling()) {
            $this->sibling->addSibling($sibling);
        } else {
            $this->sibling = $sibling;
        }

        return $this;
    }

    public function __toArray(): array
    {
        $output = [$this->field => $this->violation->__toArray()];

        if ($this->hasSibling()) {
            return array_merge($output, $this->sibling->__toArray());
        }

        return $output;
    }
}
