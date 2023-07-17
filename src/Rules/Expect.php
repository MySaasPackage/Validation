<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;
use MySaasPackage\Validation\ValidatableResult;

class Expect implements Validatable
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

    public function structure(array $structure): self
    {
        return $this->add(new Structure($structure));
    }

    public function collection(): self
    {
        return $this->add(new IsCollection());
    }

    public function collectionOf(Validatable $rule): self
    {
        return $this->add(new IsCollectionOf($rule));
    }

    public function validate(mixed $value): ValidatableResult
    {
        return $this->validateChain($this->head, $value);
    }

    protected function validateChain(ChainNode $node, mixed $value): ValidatableResult
    {
        $result = $node->validate($value);

        if ($node->hasNext()) {
            return $result->merge($this->validateChain($node->next, $value));
        }

        return $result;
    }
}
