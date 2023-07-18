<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Rules\Chain;
use MySaasPackage\Validation\Rules\IsCollection;
use MySaasPackage\Validation\Rules\IsCollectionOf;
use MySaasPackage\Validation\Rules\IsEmail;
use MySaasPackage\Validation\Rules\IsInteger;
use MySaasPackage\Validation\Rules\IsPhone;
use MySaasPackage\Validation\Rules\IsString;
use MySaasPackage\Validation\Rules\Length;
use MySaasPackage\Validation\Rules\MaxLength;
use MySaasPackage\Validation\Rules\MinLength;
use MySaasPackage\Validation\Rules\NotEmpty;
use MySaasPackage\Validation\Rules\NotNull;
use MySaasPackage\Validation\Rules\Optional;
use MySaasPackage\Validation\Rules\Required;
use MySaasPackage\Validation\Rules\Structure;

class ValidatableChain implements Validatable
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

    protected function validateChain(Chain $node, mixed $value): ValidatableResult
    {
        $result = $node->validate($value);

        if ($node->hasNext()) {
            $result = $result->merge($this->validateChain($node->next, $value));
        }

        return $result;
    }
}
