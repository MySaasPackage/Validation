<?php

declare(strict_types=1);

/* Requirements */
/* A violation has a keyword and a message. */
/* A violation can have another violation as its parent. */
/* A violation can have a collection of violations as its children. */
/* A violation can have another violation as its sibling. */

class Violation
{
    public function __construct(
        public readonly string $keyword,
        public readonly string $message,
        public readonly string $path,
        public readonly Violation|null $children = null,
        public readonly Violation|null $sibling = null,
    ) {
    }
}

$violations = new Violation(
    keyword: 'schema.mismatch',
    message: 'The schema is not valid.',
    path: '/',
    children: new Violation(
        keyword: 'required',
        message: 'The property `foo` is required.',
        path: '/foo/',
        children: new Violation(
            keyword: 'type',
            message: 'The property `foo` must be of type `string`.',
            path: '/foo/',
        ),
        sibling : new Violation(
            keyword: 'properties',
            message: 'The property `bar` is not valid.',
            path: '/bar/',
            sibling: new Violation(
                keyword: 'type',
                message: 'The property `baz` must be of type `string`.',
                path: '/baz/',
                sibling: new Violation(
                    keyword: 'enum',
                    message: 'The property `caa` must be one of the following: `bee`, `baa`.',
                    path: '/caa/',
                ),
            ),
        ),
    ),
);

function recursivePrint(Violation $violation, int $level = 0): void
{
    echo str_repeat(' ', $level * 2).$violation->message.PHP_EOL;

    if ($violation->children) {
        recursivePrint($violation->children, $level + 1);
    }

    if ($violation->sibling) {
        recursivePrint($violation->sibling, $level);
    }
}

recursivePrint($violations);
