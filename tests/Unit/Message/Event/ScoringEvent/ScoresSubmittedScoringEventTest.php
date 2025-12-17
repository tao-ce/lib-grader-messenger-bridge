<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Event\ScoringEvent;

use OAT\Library\GraderMessengerBridge\Message\Event\ScoringEvent\ScoresSubmittedScoringEvent;
use PHPUnit\Framework\TestCase;

class ScoresSubmittedScoringEventTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const DELIVERY_EXECUTION_ID = 'deliveryExecutionId';
    private const SCORER_ID = 'scorerId';
    private const TYPE        = 'taskType';
    private const SUSPICIOUS = false;
    private const NOT_ENOUGH_BASIS = false;
    private const IS_APPEAL = false;
    private const IS_ADMINISTRATIVE = false;

    private ScoresSubmittedScoringEvent $subject;

    protected function setUp(): void
    {
        $this->subject = new ScoresSubmittedScoringEvent(
            self::TENANT_ID,
            self::DELIVERY_EXECUTION_ID,
            self::SCORER_ID,
            self::TYPE,
            self::SUSPICIOUS,
            self::NOT_ENOUGH_BASIS,
            self::IS_APPEAL,
            self::IS_ADMINISTRATIVE
        );
    }

    public function testEncode(): void
    {
        $data = [
            'tenantId' => self::TENANT_ID,
            'eventName' => $this->subject->getScoringEventName(),
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'scorerId' => self::SCORER_ID,
            'scoreType' => self::TYPE,
            'suspicious' => self::SUSPICIOUS,
            'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS,
            'isAppeal' => self::IS_APPEAL,
            'isAdministrative' => self::IS_ADMINISTRATIVE
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
