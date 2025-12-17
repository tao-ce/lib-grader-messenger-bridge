<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2023 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Context;

use OAT\Library\GraderMessengerBridge\Context\Exception\ContextInvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Context\OutcomeDeclarationContext;
use PHPUnit\Framework\TestCase;

final class OutcomeDeclarationContextTest extends TestCase
{
    public function testIdException(): void
    {
        self::expectException(ContextInvalidArgumentException::class);
        self::expectExceptionMessage("OutcomeDeclaration ID can't be empty");

        new OutcomeDeclarationContext('', 123);
    }
    public function testScaleException(): void
    {
        self::expectException(ContextInvalidArgumentException::class);
        self::expectExceptionMessage("Scale value can't be empty");

        $outcomeDeclarationContext = new OutcomeDeclarationContext('outcomeDeclarationId', 123);
        $outcomeDeclarationContext->setScale(' ');
    }


    public function testToArray()
    {
        $expected = ['outcomeDeclarationId' => 'foo', 'score' => 123];
        $context = new OutcomeDeclarationContext('foo', 123);

        $this->assertSame($expected, $context->jsonSerialize());
    }

    public function testToArrayWithScale()
    {
        $expected = ['outcomeDeclarationId' => 'foo', 'score' => 123, 'scale' => 'A1'];
        $context = new OutcomeDeclarationContext('foo', 123);
        $context->setScale('A1');

        $this->assertSame($expected, $context->jsonSerialize());
    }
}
