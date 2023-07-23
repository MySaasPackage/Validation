<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use PHPUnit\Framework\TestCase;
use stdClass;

final class ValidatorTest extends TestCase
{
    public function testEmailChainSuccessful(): void
    {
        $violationOrNull = Validator::chain()->required()->email()->validate('some@email.com');
        $this->assertSame(null, $violationOrNull);
    }

    public function testPhoneChainSuccessful(): void
    {
        $violationOrNull = Validator::chain()->required()->phone()->validate('+5215555555555');
        $this->assertSame(null, $violationOrNull);
    }

    public function testKeysSuccessful(): void
    {
        $violationOrNull = Validator::arrayStruct()
            ->key('name', Validator::arrayStruct()
                ->key('firstName', Validator::chain()->required()->string())
                ->key('lastName', Validator::chain()->required()->string()))
            ->key('email', Validator::chain()->required()->email())
            ->key('phone', Validator::chain()->required()->phone())
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

    public function testPropertiesSuccessful(): void
    {
        $violationOrNull = Validator::arrayStruct()
            ->key('name', Validator::arrayStruct()
                ->key('firstName', Validator::chain()->required()->string())
                ->key('lastName', Validator::chain()->required()->string()))
            ->key('email', Validator::chain()->required()->email())
            ->key('phone', Validator::chain()->required()->phone())
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
        $dto = new stdClass();
        $dto->name = new stdClass();
        $dto->name->firstName = 'John';
        $dto->name->lastName = 'Doe';
        $dto->email = 'john@gmail.com';
        $dto->phone = '+5215555555555';
        $dto->address = ['some address'];
        $dto->leaders = [['name' => 'John Doe']];

        $violationOrNull = Validator::objectStruct()
            ->property('name', Validator::objectStruct()
                ->property('firstName', Validator::chain()->required()->string())
                ->property('lastName', Validator::chain()->required()->string()))
            ->property('email', Validator::chain()->required()->email())
            ->property('phone', Validator::chain()->required()->phone())
            ->property('address', Validator::collectionOf(Validator::chain()->required()->string()))
            ->property('leaders', Validator::collectionOf(Validator::arrayStruct()->key('name', Validator::chain()->required()->string())))
            ->validate($dto);

        $this->assertSame(null, $violationOrNull);
    }

    public function testCollectionSuccessful(): void
    {
        $violationOrNull = Validator::collectionOf(Validator::chain()->required()->email())->validate(['alef@gmail.com', 'sara@gmail.com']);

        $this->assertSame(null, $violationOrNull);
    }

    public function testCollectionFailed(): void
    {
        $violationOrNull = Validator::collectionOf(Validator::chain()->required()->email())->validate(['a', 'c']);

        $this->assertNotSame(null, $violationOrNull);
    }
}
