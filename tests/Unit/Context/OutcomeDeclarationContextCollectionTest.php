<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Context;

use OAT\Library\GraderMessengerBridge\Context\OutcomeDeclarationContext;
use OAT\Library\GraderMessengerBridge\Context\OutcomeDeclarationContextCollection;
use PHPUnit\Framework\TestCase;

class OutcomeDeclarationContextCollectionTest extends TestCase
{
    public function testToArray()
    {
        $expected = [
            ['outcomeDeclarationId' => 'foo', 'score' => 123],
        ];

        $contextCollection = new OutcomeDeclarationContextCollection();
        $contextCollection->addOutcomeDeclaration(
            $outcomeDeclarationContext = new OutcomeDeclarationContext('foo', 123)
        );

        $this->assertSame($expected, $contextCollection->jsonSerialize());
        $this->assertSame($contextCollection->getOutcomeDeclarations(), [$outcomeDeclarationContext]);
    }
}
