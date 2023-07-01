<?php

declare(strict_types=1);

namespace Eclesi\Validation;

class RuleChainBuilder
{
    protected readonly ExpressionParser $parser;

    public function __construct()
    {
        $this->parser = new ExpressionParser();
    }

    public function expression(string $expression): RuleValidatorChain
    {
        $chain = new RuleValidatorChain();

        foreach ($this->parser->parse($expression) as $ruleDefinition) {
            $chain->applyRuleDefinitionOrThrow($ruleDefinition);
        }

        return $chain;
    }
}
