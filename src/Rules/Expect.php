<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use MySaasPackage\Validation\Validatable;

class Expect implements Validatable
{
    protected Chain|null $head = null;
    protected Chain|null $tail = null;

    public function __construct(
        protected array $rules = []
    ) {
        foreach ($rules as $rule) {
            $this->add($rule);
        }
    }

    public function add(Validatable $rule): self
    {
        $node = new Chain($rule);

        if (!$this->head instanceof Chain) {
            $this->head = $node;
            $this->tail = $node;

            return $this;
        }

        $this->tail->setNextRule($node);
        $this->tail = $node;

        return $this;
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
        return $this->add(new StringType());
    }

    public function integer(): self
    {
        return $this->add(new IntegerType());
    }

    public function phone(): self
    {
        return $this->add(new PhoneType());
    }

    public function email(): self
    {
        return $this->add(new EmailType());
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

    public function collection(Validatable $rule): self
    {
        return $this->add(new CollectionType($rule));
    }

    public function validate(mixed $value): RuleResult|SchemaResult
    {
        return $this->validateChain($this->head, $value);
    }

    protected function validateChain(Chain $node, mixed $value): RuleResult|SchemaResult
    {
        $result = $node->validate($value);

        if ($node->hasNext()) {
            return $result->merge($this->validateChain($node->next, $value));
        }

        return $result;
    }
}
