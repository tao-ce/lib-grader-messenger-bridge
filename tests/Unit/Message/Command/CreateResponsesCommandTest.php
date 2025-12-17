<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Command;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\Command\CreateResponsesCommand;
use PHPUnit\Framework\TestCase;

class CreateResponsesCommandTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const DELIVERY_ID = 'deliveryId';
    private const DELIVERY_EXECUTION_ID = 'deliveryExecutionId';
    private const TEST_TAKER_ID = 'testTakerId';
    private const TEST_TAKER_GROUP_ID = 'testTakerGroupId';
    private const RESPONSES = [1, 2, 3];
    private const ENGINE_NAME = 'scoringEngineName';
    private const ATTEMPT = 1;
    private const LOCALE = 'en_EN';

    private CreateResponsesCommand $subject;

    protected function setUp(): void
    {
        $this->subject = CreateResponsesCommand::decode([
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'testTakerId' => self::TEST_TAKER_ID,
            'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
            'responses' => self::RESPONSES,
            'engineName' => self::ENGINE_NAME,
            'attempt' => self::ATTEMPT,
            'locale' => self::LOCALE,
        ]);
    }

    public function testDecode(): void
    {
        self::assertSame(self::TENANT_ID, $this->subject->getTenantId());
        self::assertSame(self::DELIVERY_ID, $this->subject->getDeliveryId());
        self::assertSame(self::DELIVERY_EXECUTION_ID, $this->subject->getDeliveryExecutionId());
        self::assertSame(self::TEST_TAKER_ID, $this->subject->getTestTakerId());
        self::assertSame(self::TEST_TAKER_GROUP_ID, $this->subject->getTestTakerGroupId());
        self::assertSame(self::RESPONSES, $this->subject->getResponses());
        self::assertSame(self::ENGINE_NAME, $this->subject->getEngineName());
        self::assertSame(self::ATTEMPT, $this->subject->getAttempt());
        self::assertSame(self::LOCALE, $this->subject->getLocale());
    }

    public function testDecodeWithNoAttempt(): void
    {
        $subject= CreateResponsesCommand::decode([
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'testTakerId' => self::TEST_TAKER_ID,
            'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
            'responses' => self::RESPONSES,
            'engineName' => self::ENGINE_NAME,
            'locale' => self::LOCALE,
        ]);

        $this->assertSame(1, $subject->getAttempt());
    }

    /** @dataProvider getInvalidDecodeData */
    public function testDecodeInvalid($invalidData): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->subject::decode($invalidData);
    }

    public function getInvalidDecodeData(): array
    {
        return [
            'invalid-attempt' => [
                [
                    'tenantId' => '123',
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => '123',
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-tenant-id' => [
                [
                    'tenantId' => 123,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-tenant-id' => [
                [
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => 123,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-delivery-execution-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => 123,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-delivery-execution-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-test-taker-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => 123,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-test-taker-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-test-taker-group-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => 123,
                    'responses' => self::RESPONSES,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-responses' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => 123,
                    'attempt' => self::ATTEMPT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-locale' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'engineName' => self::ENGINE_NAME,
                    'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
                    'responses' => 123,
                    'attempt' => self::ATTEMPT,
                    'locale' => 123,
                ],
            ],
        ];
    }

    public function testEncode(): void
    {
        $data = [
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'testTakerId' => self::TEST_TAKER_ID,
            'engineName' => self::ENGINE_NAME,
            'attempt' =>self::ATTEMPT,
            'locale' => self::LOCALE,
            'testTakerGroupId' => self::TEST_TAKER_GROUP_ID,
            'responses' => self::RESPONSES,
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
