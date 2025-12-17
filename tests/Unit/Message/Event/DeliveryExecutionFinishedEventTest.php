<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Event;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\Event\DeliveryExecutionFinishedEvent;
use PHPUnit\Framework\TestCase;

class DeliveryExecutionFinishedEventTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const DELIVERY_ID = 'deliveryId';
    private const DELIVERY_EXECUTION_ID = 'deliveryExecutionId';
    private const TEST_TAKER_ID = 'testTakerId';
    private const TEST_TAKER_GROUP_IDS = [1, 2, 3];
    private const CLIENT_ID = 'clientId';
    private const ORIGINAL_ISSUER = 'originalIssuer';
    private const AGS = [1, 2, 3];
    private const ATTEMPT = 1;
    private const LOCALE = 'en_EN';

    private DeliveryExecutionFinishedEvent $subject;

    protected function setUp(): void
    {
        $this->subject = DeliveryExecutionFinishedEvent::decode([
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'testTakerId' => self::TEST_TAKER_ID,
            'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
            'clientId' => self::CLIENT_ID,
            'originalIssuer' => self::ORIGINAL_ISSUER,
            'ags' => self::AGS,
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
        self::assertSame(self::TEST_TAKER_GROUP_IDS, $this->subject->getTestTakerGroupIds());
        self::assertSame(self::CLIENT_ID, $this->subject->getClientId());
        self::assertSame(self::ORIGINAL_ISSUER, $this->subject->getOriginalIssuer());
        self::assertSame(self::AGS, $this->subject->getAgs());
        self::assertSame(self::ATTEMPT, $this->subject->getAttempt());
        self::assertSame(self::LOCALE, $this->subject->getLocale());
    }

    public function testDecodeWithNoAttempt(): void
    {
        $subject = DeliveryExecutionFinishedEvent::decode([
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'testTakerId' => self::TEST_TAKER_ID,
            'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
            'clientId' => self::CLIENT_ID,
            'originalIssuer' => self::ORIGINAL_ISSUER,
            'ags' => self::AGS,
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
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
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
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,

                ],
            ],
            'missing-tenant-id' => [
                [
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => 123,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-delivery-execution-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => 123,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-delivery-execution-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-test-taker-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => 123,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-test-taker-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-test-taker-groups-ids' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => 123,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-test-taker-groups-ids' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-client-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => 123,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-original-issuer' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => 123,
                    'ags' => self::AGS,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-ags' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => 123,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-locale' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'testTakerId' => self::TEST_TAKER_ID,
                    'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
                    'clientId' => self::CLIENT_ID,
                    'originalIssuer' => self::ORIGINAL_ISSUER,
                    'ags' => self::AGS,
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
            'testTakerGroupIds' => self::TEST_TAKER_GROUP_IDS,
            'attempt' => self::ATTEMPT,
            'locale' => self::LOCALE,
            'clientId' => self::CLIENT_ID,
            'originalIssuer' => self::ORIGINAL_ISSUER,
            'ags' => self::AGS,
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
