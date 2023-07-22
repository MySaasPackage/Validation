<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Violations;

use MySaasPackage\Validation\Violation;

class CollectionViolation implements Violation
{
    protected CollectionViolation|null $sibling = null;

    public string $keyword = 'collection';

    public function __construct(
        public Violation $violation
    ) {
    }

    public function getSibling(): CollectionViolation|null
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
        if ($this->hasSibling()) {
            ['items' => $items] = $this->sibling->__toArray();

            return [[
                'keyword' => $this->keyword,
                'items' => [
                    $this->violation->__toArray(),
                    ...$items,
                ],
            ]];
        }

        return [['keyword' => $this->keyword, 'items' => [$this->violation->__toArray()]]];
    }
}
