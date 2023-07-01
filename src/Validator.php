<?php

declare(strict_types=1);

namespace Eclesi\Validation;

class Validator
{
    protected readonly RuleChainBuilder $ruleChainBuilder;

    public function __construct()
    {
        $this->ruleChainBuilder = new RuleChainBuilder();
    }

    public static function create(): Validator
    {
        return new self();
    }

    public static function schema(): ValidatorSchema
    {
        return new ValidatorSchema();
    }

    public function expression(string $expression): RuleValidatorChain
    {
        return $this->ruleChainBuilder->expression($expression);
    }
}
