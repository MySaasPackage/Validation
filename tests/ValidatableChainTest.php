<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use PHPUnit\Framework\TestCase;

final class ValidatableChainTest extends TestCase
{
    public function testSuccessfully(): void
    {
        $chain = ValidatableChain::create()
            ->required()
            ->length(8, 20);

        $result = $chain->validate('alef@gmail.com');
        $this->assertTrue($result->isSucceeded());
    }

    public function testCollectionSuccessfully(): void
    {
        $chain = ValidatableChain::create()
            ->collection();

        $result = $chain->validate(['alef@gmail.com']);
        $this->assertTrue($result->isSucceeded());
    }

    public function testCollectionOfSuccessfully(): void
    {
        $chain = ValidatableChain::create()
            ->collectionOf(ValidatableChain::create()->email());

        $result = $chain->validate(['alef@gmail.com', 'sara@gmail.com']);
        $this->assertTrue($result->isSucceeded());
    }

    public function testEmailSuccessfully(): void
    {
        $chain = ValidatableChain::create()
            ->required()
            ->email();

        $result = $chain->validate('alef@gmail.com');
        $this->assertTrue($result->isSucceeded());
    }

    public function testPhoneSuccessfully(): void
    {
        $chain = ValidatableChain::create()
            ->required()
            ->phone();

        $result = $chain->validate('+525592345678');
        $this->assertTrue($result->isSucceeded());
    }
}
