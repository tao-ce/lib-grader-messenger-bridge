<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Command;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\Command\CreateDeliveryCommand;
use PHPUnit\Framework\TestCase;

class CreateDeliveryCommandTest extends TestCase
{
    private const TENANT_ID = 'tenantId';
    private const DELIVERY_ID = 'deliveryId';
    private const TEST_TITLE = 'testTitle';
    private const TEST_QTI_IDENTIFIER = 'testQtiIdentifier';
    private const RECEIVED_AT = 123;
    private const ITEMS = [1, 2, 3];
    private const TEST = [41, 42, 43];
    private const ENGINE_NAME = 'scoringEngineName';

    private CreateDeliveryCommand $subject;

    protected function setUp(): void
    {
        $this->subject = CreateDeliveryCommand::decode([
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'testTitle' => self::TEST_TITLE,
            'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
            'receivedAt' => self::RECEIVED_AT,
            'items' => self::ITEMS,
            'test' => self::TEST,
            'engineName' => self::ENGINE_NAME,
        ]);
    }

    public function testDecode(): void
    {
        self::assertSame(self::TENANT_ID, $this->subject->getTenantId());
        self::assertSame(self::DELIVERY_ID, $this->subject->getDeliveryId());
        self::assertSame(self::TEST_TITLE, $this->subject->getTestTitle());
        self::assertSame(self::TEST_QTI_IDENTIFIER, $this->subject->getTestQtiIdentifier());
        self::assertSame(self::RECEIVED_AT, $this->subject->getReceivedAt());
        self::assertSame(self::ITEMS, $this->subject->getItems());
        self::assertSame(self::ENGINE_NAME, $this->subject->getEngineName());
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
            'invalid-tenant-id' => [
                [
                    'tenantId' => 123,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'missing-tenant-id' => [
                [
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'invalid-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => 123,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'missing-delivery-id' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'invalid-test-title' => [
                [
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => 123,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'missing-test-title' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'invalid-test-qti-identifier' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => 123,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'missing-test-qti-identifier' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'invalid-received-at' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => '123',
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'missing-received-at' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'invalid-items' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => 123,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'missing-items' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'test' => self::TEST,
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'invalid-test' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => 'foobar',
                    'engineName' => self::ENGINE_NAME,
                ],
            ],
            'invalid-engine-name' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                    'engineName' => 123,
                ],
            ],
            'missing-engine-name' => [
                [
                    'tenantId' => self::TENANT_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testTitle' => self::TEST_TITLE,
                    'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
                    'receivedAt' => self::RECEIVED_AT,
                    'items' => self::ITEMS,
                    'test' => self::TEST,
                ],
            ],
        ];
    }

    public function testEncode(): void
    {
        $data = [
            'tenantId' => self::TENANT_ID,
            'deliveryId' => self::DELIVERY_ID,
            'testTitle' => self::TEST_TITLE,
            'testQtiIdentifier' => self::TEST_QTI_IDENTIFIER,
            'receivedAt' => self::RECEIVED_AT,
            'items' => self::ITEMS,
            'test' => self::TEST,
            'engineName' => self::ENGINE_NAME,
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
