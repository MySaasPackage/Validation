<?php

declare(strict_types=1);

namespace Eclesi\Validation;

class ValidatorSchema
{
    protected array $schema = [];
    protected readonly RuleChainBuilder $ruleChainBuilder;

    public function __construct()
    {
        $this->ruleChainBuilder = new RuleChainBuilder();
    }

    protected function extractValueStrategyByExpression(string $expression): string
    {
        if (str_contains($expression, 'sameAs')) {
            return 'input';
        }

        return 'property';
    }

    protected function extractValueByStrategy(
        ValidatorInput $validatorInput,
        string $strategy,
        string $property
    ): mixed {
        if ('input' === $strategy) {
            return $validatorInput;
        }

        return $validatorInput->getOrNull($property);
    }

    public function expression(string $property, string $expression): self
    {
        $this->schema[] = [
            'property' => $property,
            'rule' => $this->ruleChainBuilder->expression($expression),
            'strategy' => $this->extractValueStrategyByExpression($expression),
        ];

        return $this;
    }

    public function validate(ValidatorInput $validatorInput): ValidatorResult
    {
        $violations = [];
        foreach ($this->schema as ['property' => $property, 'rule' => $rule, 'strategy' => $strategy]) {
            $value = $this->extractValueByStrategy($validatorInput, $strategy, $property);

            $result = $rule->validate($value);
            if ($result->isNotValid()) {
                $violations[$property] = $result->getViolations();
            }
        }

        return new ValidatorResult($validatorInput, $violations);
    }
}
