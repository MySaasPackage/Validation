<?php

declare(strict_types=1);

namespace MySaasPackage\Validation;

use PHPUnit\Framework\TestCase;

final class ViolationsResultTest extends TestCase
{
    public function testCreateSucceededRuleValidationResult(): void
    {
        $result = ViolationsResult::succeeded();
        $this->assertTrue($result->isSucceeded());
        $this->assertFalse($result->isFailed());
    }

    public function testCreateFailedRuleValidationResult(): void
    {
        $violation = new Violation(keyword: 'keyword');

        $result = ViolationsResult::failed($violation);
        $this->assertFalse($result->isSucceeded());
        $this->assertTrue($result->isFailed());
        $this->assertEquals([$violation], $result->getViolations());
    }
}
