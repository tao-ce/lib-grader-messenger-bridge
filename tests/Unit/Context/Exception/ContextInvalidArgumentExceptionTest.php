<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace App\Tests\Unit\Gateway\Context\Exception;

use OAT\Library\GraderMessengerBridge\Context\Exception\ContextInvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ContextInvalidArgumentExceptionTest extends TestCase
{
    public function testInvalidScores(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("Scores can't be empty");

        throw ContextInvalidArgumentException::invalidScores();
    }

    public function testInvalidElementId(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("Element ID can't be empty");

        throw ContextInvalidArgumentException::invalidElementId();
    }

    public function testInvalidDeliveryId(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("Delivery ID can't be empty");

        throw ContextInvalidArgumentException::invalidDeliveryId();
    }

    public function testInvalidDeliveryExecutionId(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("DeliveryExecution ID can't be empty");

        throw ContextInvalidArgumentException::invalidDeliveryExecutionId();
    }

    public function testInvalidOutcomeDeclarations(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("OutcomeDeclarations can't be empty");

        throw ContextInvalidArgumentException::invalidOutcomeDeclarations();
    }

    public function testInvalidOutcomeDeclarationId(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("OutcomeDeclaration ID can't be empty");

        throw ContextInvalidArgumentException::invalidOutcomeDeclarationId();
    }

    public function testInvalidScore(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("Score value cant be `NULL` without NotEnoughBasisForAssessmentFlag");

        throw ContextInvalidArgumentException::invalidScore();
    }

    public function testInvalidScale(): void
    {
        $this->expectException(ContextInvalidArgumentException::class);
        $this->expectExceptionMessage("Scale value can't be empty");

        throw ContextInvalidArgumentException::invalidScale();
    }
}
