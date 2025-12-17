<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Context;

use OAT\Library\GraderMessengerBridge\Context\Exception\ContextInvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Context\OutcomeDeclarationContext;
use OAT\Library\GraderMessengerBridge\Context\OutcomeDeclarationContextCollection;
use OAT\Library\GraderMessengerBridge\Context\ScoreContext;
use PHPUnit\Framework\TestCase;

class ScoreContextTest extends TestCase
{
    public function testElementIdException(): void
    {
        self::expectException(ContextInvalidArgumentException::class);
        self::expectExceptionMessage("Element ID can't be empty");

        $outcomeDeclarationContextCollection =  new OutcomeDeclarationContextCollection();
        $outcomeDeclarationContextCollection->addOutcomeDeclaration(
            new OutcomeDeclarationContext('foo', 123)
        );

        new ScoreContext(
            '',
            false,
            $outcomeDeclarationContextCollection
        );
    }
    public function testToArray()
    {
        $expected = [
            'elementId' => 'foo',
            'isTestLevel' => false,
            'outcomeDeclarations' => [['outcomeDeclarationId' => 'foo', 'score' => 123]]
        ];

        $outcomeDeclarationContextCollection =  new OutcomeDeclarationContextCollection();
        $outcomeDeclarationContextCollection->addOutcomeDeclaration(
            new OutcomeDeclarationContext('foo', 123)
        );

        $scoreContext = new ScoreContext(
            'foo',
            false,
            $outcomeDeclarationContextCollection
        );

        $this->assertSame($expected, $scoreContext->jsonSerialize());

        $expected = [
            'elementId' => 'foo',
            'isTestLevel' => false,
            'outcomeDeclarations' => [['outcomeDeclarationId' => 'foo', 'score' => 123, 'scale' => 'A1']]
        ];

        $outcomeDeclarationContextCollection =  new OutcomeDeclarationContextCollection();
        $outcomeDeclarationContext = new OutcomeDeclarationContext('foo', 123);
        $outcomeDeclarationContext->setScale('A1');

        $outcomeDeclarationContextCollection->addOutcomeDeclaration(
            $outcomeDeclarationContext
        );

        $scoreContext = new ScoreContext(
            'foo',
            false,
            $outcomeDeclarationContextCollection
        );

        $this->assertSame($expected, $scoreContext->jsonSerialize());
    }
}
