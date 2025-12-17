<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Context;

use OAT\Library\GraderMessengerBridge\Context\OutcomeDeclarationContext;
use OAT\Library\GraderMessengerBridge\Context\OutcomeDeclarationContextCollection;
use OAT\Library\GraderMessengerBridge\Context\ScoreContext;
use OAT\Library\GraderMessengerBridge\Context\ScoreContextCollection;
use PHPUnit\Framework\TestCase;

class ScoreContextCollectionTest extends TestCase
{
    public function testToArray()
    {
        $outcomeDeclarationContext =  new  OutcomeDeclarationContext('foo', 123);
        $outcomeDeclarationContextCollection = new OutcomeDeclarationContextCollection();
        $outcomeDeclarationContextCollection->addOutcomeDeclaration($outcomeDeclarationContext);

        $scoreContext = new ScoreContext('foo', false, $outcomeDeclarationContextCollection);

        $expected = [
            [
                'elementId' => 'foo',
                'isTestLevel' => false,
                'outcomeDeclarations' => [['outcomeDeclarationId' => 'foo', 'score' => 123]],
            ],
        ];

        $scoreContextCollection = new ScoreContextCollection();
        $scoreContextCollection->addScoreContext($scoreContext);

        $this->assertSame($expected, $scoreContextCollection->jsonSerialize());
        $this->assertSame($scoreContextCollection->getScores(), [$scoreContext]);
    }
}
