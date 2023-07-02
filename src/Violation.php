<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

readonly class Violation
{
    public function __construct(
        public readonly string $keyword,
        public readonly mixed $args = null,
        public readonly string|null $message = null
    ) {
    }

    public function __toArray(): array
    {
        $output = [
            'keyword' => $this->keyword,
        ];

        if (null !== $this->args) {
            $output['args'] = $this->args;
        }

        if (null !== $this->message) {
            $output['message'] = $this->message;
        }

        return $output;
    }
}
