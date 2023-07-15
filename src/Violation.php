<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class Violation
{
    protected ?Violation $children;
    protected ?Violation $sibling;

    public function __construct(
        public readonly string $keyword,
        public readonly string $message,
        public readonly mixed $args = null
    ) {
    }

    public function getChildren(): ?Violation
    {
        return $this->children;
    }

    public function getSibling(): ?Violation
    {
        return $this->sibling;
    }

    public function addChild(Violation $violation): void
    {
        if (null === $this->children) {
            $this->children = $violation;
        } else {
            $this->children->addSibling($violation);
        }
    }

    public function addSibling(Violation $violation): void
    {
        if (null === $this->sibling) {
            $this->sibling = $violation;
        } else {
            $this->sibling->addSibling($violation);
        }
    }
}
