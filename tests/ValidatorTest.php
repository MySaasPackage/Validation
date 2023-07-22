<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use MySaasPackage\Validation\Validator as V;
use PHPUnit\Framework\TestCase;

final class ValidatorTest extends TestCase
{
    public function testEmailChainSuccessful(): void
    {
        $violationOrNull = V::scalar()->required()->email()->validate('some@email.com');
        $this->assertSame(null, $violationOrNull);
    }

    public function testPhoneChainSuccessful(): void
    {
        $violationOrNull = V::scalar()->required()->phone()->validate('+5215555555555');
        $this->assertSame(null, $violationOrNull);
    }

    public function testKeysSuccessful(): void
    {
        $violationOrNull = V::structure()
            ->key('name', V::structure()
                ->key('firstName', V::scalar()->required()->string())
                ->key('lastName', V::scalar()->required()->string()))
            ->key('email', V::scalar()->required()->email())
            ->key('phone', V::scalar()->required()->phone())
            ->validate([
                'name' => [
                    'firstName' => 'John',
                    'lastName' => 'Doe',
                ],
                'email' => 'john@gmail.com',
                'phone' => '+5215555555555',
            ]);

        $this->assertSame(null, $violationOrNull);
    }

    public function testKeysFailed(): void
    {
        $violationOrNull = V::structure()
            ->key('name', V::structure()
                ->key('firstName', V::scalar()->required()->string())
                ->key('lastName', V::scalar()->required()->string()))
            ->key('email', V::scalar()->required()->email())
            ->key('phone', V::scalar()->required()->phone())
            ->key('address', V::collectionOf(V::scalar()->required()->string()))
            ->key('leaders', V::collectionOf(V::structure()->key('name', V::scalar()->required()->string())))
            ->validate([]);

        $this->assertNotSame(null, $violationOrNull);
    }

    public function testCollectionSuccessful(): void
    {
        $violationOrNull = V::collectionOf(V::scalar()->required()->email())->validate(['alef@gmail.com', 'sara@gmail.com']);

        $this->assertSame(null, $violationOrNull);
    }

    public function testCollectionFailed(): void
    {
        $violationOrNull = V::collectionOf(V::scalar()->required()->email())->validate(['a', 'c']);

        $this->assertNotSame(null, $violationOrNull);
    }
}
