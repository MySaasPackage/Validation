<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Violations;

use MySaasPackage\Validation\Violation;

class SimpleViolation implements Violation
{
    protected Violation|null $sibling = null;

    public function __construct(
        public readonly string $keyword,
        public readonly string $message,
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
        $output = ['keyword' => $this->keyword, 'message' => $this->message];

        if ($this->hasSibling()) {
            return [$output, ...$this->sibling->__toArray()];
        }

        return [$output];
    }
}
