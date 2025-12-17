<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Command;

use Carbon\Carbon;
use OAT\Library\GraderMessengerBridge\Message\AbstractTenantAwareMessage;
use OAT\Library\GraderMessengerBridge\Message\SerializableMessage;
use OAT\Library\GraderMessengerBridge\Validator\ArgumentValidatorTrait;

class SendScoresCommand extends AbstractTenantAwareMessage implements SerializableMessage
{
    use ArgumentValidatorTrait;

    public const TENANT_ID                              = 'tenantId';
    public const SCORER_ID                              = 'scorerId';
    public const TYPE                                   = 'type';
    public const DELIVERY_ID                            = 'deliveryId';
    public const DELIVERY_EXECUTION_ID                  = 'deliveryExecutionId';
    public const ATTEMPT                                = 'attempt';
    public const SCORES                                 = 'scores';
    public const SUSPICIOUS                             = 'suspicious';
    public const SUSPICIOUS_NOTE                        = 'suspiciousNote';
    public const NOT_ENOUGH_BASIS_FOR_ASSESSMENT        = 'notEnoughBasisForAssessment';
    public const NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE   = 'notEnoughBasisForAssessmentNote';
    public const SCORING_STRATEGY                       = 'scoringStrategy';
    public const SCORING_STRATEGY_SETTINGS              = 'scoringStrategySettings';
    public const IS_APPEAL                              = 'isAppeal';
    public const IS_REVIEW                              = 'isReview';
    public const IS_ADMINISTRATIVE                      = 'isAdministrative';
    public const EVENT_TIMESTAMP                        = 'eventTimestamp';

    public function __construct(
        string          $tenantId,
        private readonly string  $scorerId,
        private readonly string  $type,
        private readonly string  $deliveryId,
        private readonly string  $deliveryExecutionId,
        private readonly int     $attempt,
        private readonly array   $scores,
        private readonly Carbon  $eventTimestamp,
        private readonly bool    $isReview = false,
        private readonly bool    $suspicious = false,
        private readonly bool    $notEnoughBasisForAssessment = false,
        private readonly bool    $isAppeal = false,
        private readonly ?string $scoringStrategy = null,
        private readonly ?array  $scoringStrategySettings = null,
        private readonly ?string $suspiciousNote = null,
        private readonly ?string $notEnoughBasisForAssessmentNote = null,
        private readonly bool    $isAdministrative = false,
    ) {
        parent::__construct($tenantId);
    }

    public static function decode(array $data): self
    {
        self::validateData($data);

        return new self(
            $data[self::TENANT_ID],
            $data[self::SCORER_ID],
            $data[self::TYPE],
            $data[self::DELIVERY_ID],
            $data[self::DELIVERY_EXECUTION_ID],
            $data[self::ATTEMPT],
            $data[self::SCORES],
            Carbon::createFromFormat('Y-m-d\TH:i:sO', $data[self::EVENT_TIMESTAMP]),
            $data[self::IS_REVIEW] ?? false,
            $data[self::SUSPICIOUS] ?? false,
            $data[self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT] ?? false,
            $data[self::IS_APPEAL] ?? false,
            $data[self::SCORING_STRATEGY] ?? null,
            $data[self::SCORING_STRATEGY_SETTINGS] ?? null,
            $data[self::SUSPICIOUS_NOTE] ?? null,
            $data[self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE] ?? null,
            $data[self::IS_ADMINISTRATIVE] ?? false,
        );
    }

    public function encode(): array
    {
        return [
            self::TENANT_ID => $this->getTenantId(),
            self::SCORER_ID => $this->scorerId,
            self::TYPE => $this->type,
            self::DELIVERY_ID => $this->deliveryId,
            self::DELIVERY_EXECUTION_ID => $this->deliveryExecutionId,
            self::ATTEMPT => $this->attempt,
            self::SCORES => $this->scores,
            self::EVENT_TIMESTAMP => $this->eventTimestamp->format('Y-m-d\TH:i:sO'),
            self::IS_REVIEW => $this->isReview,
            self::SUSPICIOUS => $this->suspicious,
            self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT => $this->notEnoughBasisForAssessment,
            self::SCORING_STRATEGY => $this->scoringStrategy,
            self::SCORING_STRATEGY_SETTINGS => $this->scoringStrategySettings,
            self::SUSPICIOUS_NOTE => $this->suspiciousNote,
            self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE => $this->notEnoughBasisForAssessmentNote,
            self::IS_APPEAL => $this->isAppeal,
            self::IS_ADMINISTRATIVE => $this->isAdministrative,
        ];
    }

    public function getScorerId(): string
    {
        return $this->scorerId;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDeliveryId(): string
    {
        return $this->deliveryId;
    }

    public function getDeliveryExecutionId(): string
    {
        return $this->deliveryExecutionId;
    }

    public function getAttempt(): int
    {
        return $this->attempt;
    }

    public function getScores(): array
    {
        return $this->scores;
    }

    public function isReview(): bool
    {
        return $this->isReview;
    }

    public function isSuspicious(): bool
    {
        return $this->suspicious;
    }

    public function isNotEnoughBasisForAssessment(): bool
    {
        return $this->notEnoughBasisForAssessment;
    }

    public function isAppeal(): bool
    {
        return $this->isAppeal;
    }

    public function getScoringStrategy(): ?string
    {
        return $this->scoringStrategy;
    }

    public function getScoringStrategySettings(): ?array
    {
        return $this->scoringStrategySettings;
    }

    public function getSuspiciousNote(): ?string
    {
        return $this->suspiciousNote;
    }

    public function getNotEnoughBasisForAssessmentNote(): ?string
    {
        return $this->notEnoughBasisForAssessmentNote;
    }

    public function getEventTimestamp(): Carbon
    {
        return $this->eventTimestamp;
    }

    public function isAdministrative(): bool
    {
        return $this->isAdministrative;
    }

    private static function validateData(array $data): void
    {
        foreach ([self::TENANT_ID, self::SCORER_ID, self::TYPE, self::DELIVERY_ID, self::DELIVERY_EXECUTION_ID] as $key) {
            self::validateRequiredString($data, $key);
        }

        self::validateRequiredInt($data, self::ATTEMPT);
        self::validateRequiredArray($data, self::SCORES);
        self::validateOptionalBool($data, self::IS_REVIEW);
        self::validateOptionalBool($data, self::SUSPICIOUS);
        self::validateOptionalBool($data, self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT);
        self::validateOptionalBool($data, self::IS_APPEAL);
        self::validateOptionalBool($data, self::IS_ADMINISTRATIVE);

        self::validateOptionalString($data, self::SCORING_STRATEGY);
        self::validateOptionalArray($data, self::SCORING_STRATEGY_SETTINGS);

        self::validateOptionalString($data, self::SUSPICIOUS_NOTE);
        self::validateOptionalString($data, self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE);
    }
}
