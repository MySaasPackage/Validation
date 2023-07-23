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
        $violationOrNull = Validator::arrayStructure()
            ->key('name', Validator::arrayStructure()
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
        $violationOrNull = Validator::arrayStructure()
            ->key('name', Validator::arrayStructure()
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

    public function testObjectStructuteSuccessful(): void
    {
        $mike = new stdClass();
        $mike->name = 'Mike';
        $mike->email = 'mike@gmail.com';

        $mark = new stdClass();
        $mark->name = 'Mark';
        $mark->email = 'mark@gamil.com';

        $john = new stdClass();
        $john->name = new stdClass();
        $john->name->firstName = 'John';
        $john->name->lastName = 'Doe';
        $john->email = 'john@gmail.com';
        $john->phone = '+5215555555555';
        $john->address = ['some address'];
        $john->leaders = [$mike, $mark];

        $propertyLeaderValidator = Validator::objectStructure()
            ->property('name', Validator::chain()->required()->string())
            ->property('email', Validator::chain()->required()->email());

        $propertyNameValidator = Validator::objectStructure()
            ->property('firstName', Validator::chain()->required()->string())
            ->property('lastName', Validator::chain()->required()->string());

        $violationOrNull = Validator::objectStructure()
            ->property('name', $propertyNameValidator)
            ->property('email', Validator::chain()->required()->email())
            ->property('phone', Validator::chain()->required()->phone())
            ->property('address', Validator::chain()->collectionOf(Validator::chain()->required()->string()))
            ->property('leaders', Validator::chain()->count(2)->collectionOf($propertyLeaderValidator))
            ->validate($john);

        $this->assertSame(null, $violationOrNull);
    }

    public function testCollectionSuccessful(): void
    {
        $violationOrNull = Validator::chain()->collectionOf(Validator::chain()->required()->email())->validate(['alef@gmail.com', 'sara@gmail.com']);

        $this->assertSame(null, $violationOrNull);
    }

    public function testCollectionFailed(): void
    {
        $violationOrNull = Validator::chain()->collectionOf(Validator::chain()->required()->email())->validate(['a', 'c']);

        $this->assertNotSame(null, $violationOrNull);
    }
}
