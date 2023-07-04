<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class ChainedRule
{
    protected RuleNode|null $head = null;
    protected RuleNode|null $tail = null;

    public function __construct(
        protected array $rules = []
    ) {
        foreach ($rules as $rule) {
            $this->add($rule);
        }
    }

    public function add(Rule $rule): self
    {
        $node = new RuleNode($rule);

        if (!$this->head instanceof RuleNode) {
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
        return $this->add(new Rules\Required());
    }

    public function optional(): self
    {
        return $this->add(new Rules\Optional());
    }

    public function rule(RuleNode $rule): self
    {
        return $this->add($rule);
    }

    public function string(): self
    {
        return $this->add(new Rules\StringType());
    }

    public function integer(): self
    {
        return $this->add(new Rules\IntegerType());
    }

    public function phone(): self
    {
        return $this->add(new Rules\PhoneType());
    }

    public function email(): self
    {
        return $this->add(new Rules\EmailType());
    }

    public function notEmpty(): self
    {
        return $this->add(new Rules\NotEmpty());
    }

    public function notNull(): self
    {
        return $this->add(new Rules\NotNull());
    }

    public function length(string|int $min, string|int $max): self
    {
        return $this->add(new Rules\Length(
            minLength: new Rules\MinLength($min),
            maxLength: new Rules\MaxLength($max)
        ));
    }

    public function minLength(int $min): self
    {
        return $this->add(new Rules\MinLength($min));
    }

    public function maxLength(int $max): self
    {
        return $this->add(new Rules\MaxLength($max));
    }

    public function validate(mixed $value): RuleValidationResult
    {
        return $this->validateChain($this->head, $value);
    }

    protected function validateChain(RuleNode $node, mixed $value): RuleValidationResult
    {
        $result = $node->validate($value);

        if ($node->hasNext()) {
            return $result->merge($this->validateChain($node->next, $value));
        }

        return $result;
    }
}
