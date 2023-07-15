<?php

declare(strict_types=1);

$violation = new Violation(
    keyword: 'schema.mismatch',
    message: 'The schema is not valid.',
    path: '/',
);

$violation->addChild(
    new Violation(
        keyword: 'required',
        message: 'The property `foo` is required.',
        path: '/foo/',
    )
);

$violation->addChild(
    new Violation(
        keyword: 'required',
        message: 'The property `bar` is not valid.',
        path: '/bar/',
    )
);

$collection = new Violation(
    keyword: 'collection',
    message: 'The property `baz` is not valid.',
    path: '/collection/',
);

$collection->addChild(
    new Violation(
        keyword: 'not-string',
        message: 'The property `baz` is not valid.',
        path: '/baz/[0]/',
    )
);

$collection->addChild(
    new Violation(
        keyword: 'not-string',
        message: 'The property `baz` is not valid.',
        path: '/baz/[1]/',
    )
);

$violation->addChild($collection);

$violation->addChild(
    new Violation(
        keyword: 'required',
        message: 'The property `qux` is required.',
        path: '/qux/',
    )
);

function recursivePrint(Violation $violation, int $level = 0): void
{
    echo str_repeat(' ', $level * 2);
    echo $violation->keyword;
    echo ' - ';
    echo $violation->message;
    echo ' - ';
    echo $violation->path;
    echo PHP_EOL;

    if (null !== $violation->getChildren()) {
        recursivePrint($violation->getChildren(), $level + 1);
    }

    if (null !== $violation->getSibling()) {
        recursivePrint($violation->getSibling(), $level);
    }
}

recursivePrint($violation);
