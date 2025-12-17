<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Event;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\Event\DeliveryExecutionReadyForScoringEvent;
use PHPUnit\Framework\TestCase;

class DeliveryExecutionReadyForScoringEventTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const DELIVERY_EXECUTION_ID = 'deliveryExecutionId';
    private const ENGINE_NAME = 'manual';
    private const ENROLLMENT_ROLE = 'reviewer';

    private DeliveryExecutionReadyForScoringEvent $subject;

    protected function setUp(): void
    {
        $this->subject = DeliveryExecutionReadyForScoringEvent::decode([
            'tenantId' => self::TENANT_ID,
            'engineName' => self::ENGINE_NAME,
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'enrollmentRole' => self::ENROLLMENT_ROLE
        ]);
    }

    public function testDecode(): void
    {
        self::assertSame(self::TENANT_ID, $this->subject->getTenantId());
        self::assertSame(self::DELIVERY_EXECUTION_ID, $this->subject->getDeliveryExecutionId());
        self::assertSame(self::ENROLLMENT_ROLE, $this->subject->getEnrollmentRole());
    }

    /** @dataProvider getInvalidDecodeData */
    public function testDecodeInvalid(array $invalidData): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->subject::decode($invalidData);
    }

    public function getInvalidDecodeData(): array
    {
        return [
            'invalid-tenant-id' => [
                [
                    'tenantId' => 123,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'engineName' => self::ENGINE_NAME

                ],
            ],
            'missing-tenant-id' => [
                [
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'engineName' => self::ENGINE_NAME

                ],
            ],
            'invalid-delivery-execution-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryExecutionId' => 123,
                    'engineName' => self::ENGINE_NAME
                ],
            ],
            'missing-delivery-execution-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'engineName' => self::ENGINE_NAME
                ],
            ],
            'invalid-engine-name' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'engineName' => 123
                ],
            ],
            'missing-engine-name' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID
                ],
            ],
            'missing-enrollment-role' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
                    'engineName' => self::ENGINE_NAME
                ],
            ],
        ];
    }

    public function testEncode(): void
    {
        $data = [
            'tenantId' => self::TENANT_ID,
            'engineName' => self::ENGINE_NAME,
            'deliveryExecutionId' => self::DELIVERY_EXECUTION_ID,
            'enrollmentRole' => self::ENROLLMENT_ROLE
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
