<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event\ScoringEvent;

class ScoringStrategySuccessfulScoringEvent  extends AbstractScoringStrategyScoringEvent
{
    private const SCORING_EVENT_NAME = 'scoringStrategySuccessfulScoringEvent';

    public function getScoringEventName(): string
    {
        return self::SCORING_EVENT_NAME;
    }
}