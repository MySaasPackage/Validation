<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class Violation
{
    protected ?string $path = null;
    protected ?Violation $children = null;
    protected ?Violation $sibling = null;

    public function __construct(
        public readonly string $keyword,
        public readonly string $message,
        public readonly mixed $args = null
    ) {
    }

    public function withPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function getChildren(): ?Violation
    {
        return $this->children;
    }

    public function hasChildren(): bool
    {
        return null !== $this->children;
    }

    public function addChild(Violation $violation): self
    {
        if (null === $this->children) {
            $this->children = $violation;
        } else {
            $this->children->addSibling($violation);
        }

        return $this;
    }

    public function getSibling(): ?Violation
    {
        return $this->sibling;
    }

    public function hasSibling(): bool
    {
        return null !== $this->sibling;
    }

    public function addSibling(Violation $violation): self
    {
        if (null === $this->sibling) {
            $this->sibling = $violation;
        } else {
            $this->sibling->addSibling($violation);
        }

        return $this;
    }
}
