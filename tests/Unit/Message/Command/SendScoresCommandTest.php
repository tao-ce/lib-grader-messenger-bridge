<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Command;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\Command\SendScoresCommand;
use PHPUnit\Framework\TestCase;

class SendScoresCommandTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const SCORER_ID = 'scorerId';
    private const TYPE        = 'taskType';
    private const TAO_DELIVERY_ID = 'deliveryId';
    private const TAO_DELIVERY_EXECUTION_ID = 'deliveryExecutionId';
    private const ATTEMPT = 1;
    private const SCORES = [1, 2, 3];
    public const SUSPICIOUS = false;
    public const SUSPICIOUS_NOTE = 'suspiciousNote';
    public const NOT_ENOUGH_BASIS_FOR_ASSESSMENT = false;
    public const NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE   = 'notEnoughBasisForAssessmentNote';
    public const SCORING_STRATEGY = 'scoringStrategy';
    public const SCORING_STRATEGY_SETTINGS = [];
    private const IS_APPEAL = false;
    public const IS_REVIEW = false;
    public const EVENT_TIMESTAMP = '2023-01-27T01:36:18+0000';

    private SendScoresCommand $subject;

    protected function setUp(): void
    {
        $this->subject = SendScoresCommand::decode([
            'tenantId' => self::TENANT_ID,
            'scorerId' => self::SCORER_ID,
            'type' => self::TYPE,
            'deliveryId' => self::TAO_DELIVERY_ID,
            'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
            'attempt' => self::ATTEMPT,
            'scores' => self::SCORES,
            'eventTimestamp' => self::EVENT_TIMESTAMP,
            'isReview' => self::IS_REVIEW,
            'suspicious' => self::SUSPICIOUS,
            'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
            'isAppeal' => self::IS_APPEAL,
        ]);
    }

    public function testDecode(): void
    {
        self::assertSame(self::SCORES, $this->subject->getScores());
        self::assertSame(self::TENANT_ID, $this->subject->getTenantId());
    }

    /** @dataProvider getInvalidDecodeData */
    public function testDecodeInvalid(string $key, array $invalidData): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Invalid argument `%s`', $key));

        $this->subject::decode($invalidData);
    }

    public function getInvalidDecodeData(): array
    {
        return [
            'invalid-tenant-id' => [
                'key' => 'tenantId',
                'data' => [
                    'tenantId' => 123,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'missing-tenant-id' => [
                'key' => 'tenantId',
                'data' => [
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-scorer-id' => [
                'key' => 'scorerId',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => 123,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'missing-scorer-id' => [
                'key' => 'scorerId',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-task-type' => [
                'key' => 'type',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => 123,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'missing-task-type' => [
                'key' => 'type',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-delivery-id' => [
                'key' => 'deliveryId',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => 123,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'missing-delivery-id' => [
                'key' => 'deliveryId',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-delivery-execution-id' => [
                'key' => 'deliveryExecutionId',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => 123,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'missing-delivery-execution-id' => [
                'key' => 'deliveryExecutionId',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-scores' => [
                'key' => 'scores',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => 123,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'missing-scores' => [
                'key' => 'scores',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-suspicious' => [
                'key' => 'suspicious',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => 123,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-not-enough-basis-for-assessment' => [
                'key' => 'notEnoughBasisForAssessment',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => 123,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-scoring-strategy' => [
                'key' => 'scoringStrategy',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => 123,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-scoring-strategy-settings' => [
                'key' => 'scoringStrategySettings',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => 123,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE
                ],
            ],
            'invalid-suspicious_note' => [
                'key' => 'suspiciousNote',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => self::IS_REVIEW,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => 123,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-is_review' => [
                'key' => 'isReview',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'eventTimestamp' => self::EVENT_TIMESTAMP,
                    'isReview' => 123,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => 123,
                    'isAppeal' => self::IS_APPEAL,
                ],
            ],
            'invalid-is_appeal' => [
                'key' => 'isAppeal',
                'data' => [
                    'tenantId' => self::TENANT_ID,
                    'scorerId' => self::SCORER_ID,
                    'type' => self::TYPE,
                    'deliveryId' => self::TAO_DELIVERY_ID,
                    'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
                    'attempt' => self::ATTEMPT,
                    'scores' => self::SCORES,
                    'suspicious' => self::SUSPICIOUS,
                    'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
                    'scoringStrategy' => self::SCORING_STRATEGY,
                    'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
                    'suspiciousNote' => self::SUSPICIOUS_NOTE,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE,
                    'isAppeal' => 123,
                    'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE
                ],
            ],
        ];
    }

    public function testDecodeInvalidEventTimestamp(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("A four digit year could not be found\nNot enough data available to satisfy format");

        $this->subject::decode([
            'tenantId' => self::TENANT_ID,
            'scorerId' => self::SCORER_ID,
            'type' => self::TYPE,
            'deliveryId' => self::TAO_DELIVERY_ID,
            'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
            'attempt' => self::ATTEMPT,
            'scores' => self::SCORES,
            'eventTimestamp' => 'invalid-timestamp',
            'isReview' => self::IS_REVIEW,
            'suspicious' => self::SUSPICIOUS,
            'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
            'scoringStrategy' => self::SCORING_STRATEGY,
            'scoringStrategySettings' => self::SCORING_STRATEGY_SETTINGS,
            'suspiciousNote' => self::SUSPICIOUS_NOTE,
            'notEnoughBasisForAssessmentNote' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT_NOTE
        ]);
    }

    public function testEncode(): void
    {
        $data = [
            'tenantId' => self::TENANT_ID,
            'scorerId' => self::SCORER_ID,
            'type' => self::TYPE,
            'deliveryId' => self::TAO_DELIVERY_ID,
            'deliveryExecutionId' => self::TAO_DELIVERY_EXECUTION_ID,
            'attempt' => self::ATTEMPT,
            'scores' => self::SCORES,
            'eventTimestamp' => self::EVENT_TIMESTAMP,
            'isReview' => self::IS_REVIEW,
            'suspicious' => self::SUSPICIOUS,
            'notEnoughBasisForAssessment' => self::NOT_ENOUGH_BASIS_FOR_ASSESSMENT,
            'scoringStrategy' => null,
            'scoringStrategySettings' => null,
            'suspiciousNote' => null,
            'notEnoughBasisForAssessmentNote' => null,
            'isAppeal' => self::IS_APPEAL,
            'isAdministrative' => false,
        ];

        self::assertSame($data, $this->subject->encode());
        self::assertFalse($this->subject->isNotEnoughBasisForAssessment());
        self::assertFalse($this->subject->isSuspicious());
        self::assertFalse($this->subject->isAppeal());
        self::assertFalse($this->subject->isReview());
        self::assertFalse($this->subject->isAdministrative());
        self::assertNull($this->subject->getScoringStrategy());
        self::assertNull($this->subject->getScoringStrategySettings());
        self::assertNull($this->subject->getSuspiciousNote());
        self::assertNull($this->subject->getNotEnoughBasisForAssessmentNote());
        self::assertSame(self::EVENT_TIMESTAMP, $this->subject->getEventTimestamp()->format('Y-m-d\TH:i:sO'));
    }
}
