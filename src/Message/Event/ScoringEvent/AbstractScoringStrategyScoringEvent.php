<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event\ScoringEvent;

use InvalidArgumentException;

abstract class AbstractScoringStrategyScoringEvent extends AbstractScoringEvent
{
    protected const KEY_SCORING_STRATEGY_NAME = 'scoringStrategyName';
    protected const KEY_MESSAGE = 'message';

    public function __construct(
        string $tenantId,
        string $deliveryExecutionId,
        private string $scoringStrategyName,
        private string $message = '',
    )
    {
        parent::__construct($tenantId, $deliveryExecutionId);
    }

    public static function decode(array $data): self
    {
        // TODO: Implement decode() method.
    }

    public function encode(): array
    {
        return array_merge(
            parent::encode(),
            [
                self::KEY_SCORING_STRATEGY_NAME => $this->scoringStrategyName,
                self::KEY_MESSAGE => $this->message,
            ]
        );
    }
}