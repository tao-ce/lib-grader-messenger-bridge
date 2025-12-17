<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Event\ScoringEvent;

use OAT\Library\GraderMessengerBridge\Message\Event\ScoringEvent\ScoringStrategySuccessfulScoringEvent;
use PHPUnit\Framework\TestCase;

class ScoringStrategySuccessfulScoringEventTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const DELIVERY_EXECUTION_ID = 'deliveryExecutionId';
    private const SCORING_STRATEGY = 'threeBlindScoringStrategy';
    private const MESSAGE        = 'message';

    private ScoringStrategySuccessfulScoringEvent $subject;

    protected function setUp(): void
    {
        $this->subject = new ScoringStrategySuccessfulScoringEvent(
            self::TENANT_ID,
            self::DELIVERY_EXECUTION_ID,
            self::SCORING_STRATEGY,
            self::MESSAGE
        );
    }

    public function testEncode(): void
    {
        $data = [
            'tenantId' => self::TENANT_ID,
            'eventName' => $this->subject->getScoringEventName(),
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'scoringStrategyName' => self::SCORING_STRATEGY,
            'message' => self::MESSAGE,
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
