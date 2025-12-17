<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Event;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\Event\DeliveryPublishedEvent;
use PHPUnit\Framework\TestCase;

class DeliveryPublishedEventTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const DELIVERY_ID = 'deliveryId';
    private const CONFIGURATION = [
        'metadata' => null
    ];

    private const LOCALE = 'en_EN';

    private DeliveryPublishedEvent $subject;

    protected function setUp(): void
    {
        $this->subject = DeliveryPublishedEvent::decode([
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'configuration' => self::CONFIGURATION,
            'locale' => self::LOCALE,
        ]);
    }

    public function testDecode(): void
    {
        self::assertSame(self::TENANT_ID, $this->subject->getTenantId());
        self::assertSame(self::DELIVERY_ID, $this->subject->getDeliveryId());
        self::assertSame(self::CONFIGURATION, $this->subject->getConfiguration());
        self::assertSame(self::LOCALE, $this->subject->getLocale());
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
                    'deliveryId' => self::DELIVERY_ID,
                    'configuration' => self::CONFIGURATION,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-tenant-id' => [
                [
                    'deliveryId' => self::DELIVERY_ID,
                    'configuration' => self::CONFIGURATION,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => 123,
                    'configuration' => self::CONFIGURATION,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'configuration' => self::CONFIGURATION,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-configuration' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'configuration' => 123,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-locale' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'configuration' => self::CONFIGURATION,
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
            'configuration' => self::CONFIGURATION,
            'locale' => self::LOCALE,
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
