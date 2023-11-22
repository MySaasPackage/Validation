<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\Violation;
use MySaasPackage\Validation\Violations\ChainedViolation;

class Chained implements Validatable
{
    protected ChainNode|null $head = null;
    protected ChainNode|null $tail = null;

    public function __construct(
        protected array $rules = []
    ) {
        foreach ($rules as $rule) {
            $this->add($rule);
        }
    }

    public function add(Validatable $rule): self
    {
        $node = new ChainNode($rule);

        if (!$this->head instanceof ChainNode) {
            $this->head = $node;
            $this->tail = $node;

            return $this;
        }

        $this->tail->setNextRule($node);
        $this->tail = $node;

        return $this;
    }

    public static function create(): self
    {
        return new self();
    }

    public function required(): self
    {
        return $this->add(new Required());
    }

    public function optional(): self
    {
        return $this->add(new Optional());
    }

    public function string(): self
    {
        return $this->add(new IsString());
    }

    public function integer(): self
    {
        return $this->add(new IsInteger());
    }

    public function phone(): self
    {
        return $this->add(new IsPhone());
    }

    public function email(): self
    {
        return $this->add(new IsEmail());
    }

    public function notEmpty(): self
    {
        return $this->add(new NotEmpty());
    }

    public function notNull(): self
    {
        return $this->add(new NotNull());
    }

    public function array(): self
    {
        return $this->add(new IsArray());
    }

    public function uuid(): self
    {
        return $this->add(new IsUuid());
    }

    public function enum(string $enum): self
    {
        return $this->add(new IsEnumValid($enum));
    }

    public function object(): self
    {
        return $this->add(new IsObject());
    }

    public function length(string|int $min, string|int $max): self
    {
        return $this->add(new Length(
            minLength: new MinLength($min),
            maxLength: new MaxLength($max)
        ));
    }

    public function minLength(int $min): self
    {
        return $this->add(new MinLength($min));
    }

    public function maxLength(int $max): self
    {
        return $this->add(new MaxLength($max));
    }

    public function count(int $count): self
    {
        return $this->add(new Count($count));
    }

    public function collectionOf(Validatable $rule): self
    {
        return $this->add(new CollectionOf($rule));
    }

    public function structure(ArrayStructure|ObjectStructure $structure): self
    {
        return $this->add($structure);
    }

    public function arrayStructure(ArrayStructure $structure): self
    {
        return $this->add($structure);
    }

    public function objectStructure(ObjectStructure $structure): self
    {
        return $this->add($structure);
    }

    public function validate(mixed $value): Violation|null
    {
        $chainViolationOrNull = $this->validateChain($this->head, $value);

        if (null === $chainViolationOrNull) {
            return null;
        }

        return (new ChainedViolation())->addSibling($chainViolationOrNull);
    }

    protected function validateChain(ChainNode $node, mixed $value): Violation|null
    {
        if ($node->rule instanceof Optional && null === $value) {
            return null;
        }

        $violationOrNull = $node->validate($value);

        if ($node->doNotHaveNext()) {
            return $violationOrNull;
        }

        $chainViolationOrNull = $this->validateChain($node->next, $value);

        if (null === $chainViolationOrNull) {
            return $violationOrNull;
        }

        if (null === $violationOrNull) {
            return $chainViolationOrNull;
        }

        return $violationOrNull->addSibling($chainViolationOrNull);
    }
}
