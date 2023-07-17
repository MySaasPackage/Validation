<?php

declare(strict_types=1);

namespace MySaasPackage\Validation\Rules;

use PHPUnit\Framework\TestCase;

final class ExpectTest extends TestCase
{
    public function testCollectionSuccessfully(): void
    {
        $chain = Expect::create()
            ->collection();

        $result = $chain->validate(['alef@gmail.com']);
        $this->assertTrue($result->isSucceeded());
    }

    public function testCollectionOfSuccessfully(): void
    {
        $chain = Expect::create()
            ->collectionOf(Expect::create()->email());

        $result = $chain->validate(['alef@gmail.com', 'sara@gmail.com']);
        $this->assertTrue($result->isSucceeded());
    }

    public function testEmailSuccessfully(): void
    {
        $chain = Expect::create()
            ->required()
            ->email();

        $result = $chain->validate('alef@gmail.com');
        $this->assertTrue($result->isSucceeded());
    }

    public function testPhoneSuccessfully(): void
    {
        $chain = Expect::create()
            ->required()
            ->phone();

        $result = $chain->validate('+525592345678');
        $this->assertTrue($result->isSucceeded());
    }
}
