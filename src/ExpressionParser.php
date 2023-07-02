<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class ExpressionParser
{
    protected array $defaults;

    public function __construct()
    {
        $this->defaults = array_fill(0, 2, null);
    }

    protected function parseToRuleDefinition(string $expressionPiece): RuleDefinition
    {
        [$rule, $args] = explode(':', $expressionPiece) + $this->defaults;

        return new RuleDefinition($rule, $this->parseArgs($args));
    }

    protected function castToAppropriatedTypes(string $arg): int|string
    {
        if (is_numeric($arg)) {
            return (int) $arg;
        }

        return $arg;
    }

    protected function parseArgs(string|null $args): array|null
    {
        if (null === $args) {
            return null;
        }

        return explode(',', $args);
    }

    public function parse(string $expression): array
    {
        $rules = explode('|', $expression);

        return array_map(fn (string $part) => $this->parseToRuleDefinition($part), $rules);
    }
}
