<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class Violation
{
    protected Violation|null $childrens = null;
    protected Violation|null $sibling = null;

    public function __construct(
        public readonly string $keyword,
        public readonly string $message
    ) {
    }

    public function getChildren(): Violation|null
    {
        return $this->childrens;
    }

    public function hasChildren(): bool
    {
        return null !== $this->childrens;
    }

    public function addChild(Violation $violation): self
    {
        if (null === $this->childrens) {
            $this->childrens = $violation;
        } else {
            $this->childrens->addSibling($violation);
        }

        return $this;
    }

    public function getSibling(): Violation|null
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

    public function __toArray(): array
    {
        $item = [
            'keyword' => $this->keyword,
            'message' => $this->message,
        ];

        if ($this->hasChildren()) {
            $item['childrens'] = $this->childrens->__toArray();
        }

        if ($this->hasSibling()) {
            return array_merge([$item], $this->sibling->__toArray());
        }

        return [$item];
    }
}
