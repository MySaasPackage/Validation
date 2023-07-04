<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

class RuleChainBuilder
{
    protected readonly ExpressionParser $parser;

    public function __construct()
    {
        $this->parser = new ExpressionParser();
    }

    public function expression(string $expression): RuleChain
    {
        $chain = new RuleChain();

        foreach ($this->parser->parse($expression) as $ruleDefinition) {
            $chain->applyRuleDefinitionOrThrow($ruleDefinition);
        }

        return $chain;
    }
}
