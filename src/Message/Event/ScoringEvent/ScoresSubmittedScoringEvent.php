<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event\ScoringEvent;

class ScoresSubmittedScoringEvent extends AbstractScoringEvent
{
    private const SCORING_EVENT_NAME = 'scoresSubmittedScoringEvent';

    private const KEY_SCORER_ID = 'scorerId';
    private const KEY_SCORE_TYPE = 'scoreType';
    private const KEY_SUSPICIOUS = 'suspicious';
    private const KEY_NOT_ENOUGH_BASIS = 'notEnoughBasisForAssessment';
    private const KEY_IS_APPEAL = 'isAppeal';
    private const KEY_IS_ADMINISTRATIVE = 'isAdministrative';

    public function __construct(
        string $tenantId,
        string $deliveryExecutionId,
        private string $scorerId,
        private string $scoreType,
        private bool $suspicious,
        private bool $notEnoughBasisForAssessment,
        private bool $isAppeal,
        private bool $isAdministrative
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
                self::KEY_SCORER_ID => $this->scorerId,
                self::KEY_SCORE_TYPE => $this->scoreType,
                self::KEY_SUSPICIOUS => $this->suspicious,
                self::KEY_NOT_ENOUGH_BASIS => $this->notEnoughBasisForAssessment,
                self::KEY_IS_APPEAL => $this->isAppeal,
                self::KEY_IS_ADMINISTRATIVE => $this->isAdministrative,
            ]
        );
    }

    public function getScoringEventName(): string
    {
        return self::SCORING_EVENT_NAME;
    }
}