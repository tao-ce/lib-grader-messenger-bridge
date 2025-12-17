<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message\Command;

use InvalidArgumentException;

use OAT\Library\GraderMessengerBridge\Message\ManualResultsMessage;
use PHPUnit\Framework\TestCase;

class ManualResultsMessageTest extends TestCase
{
    private const CONTEXT_SOURCED_ID = 'contextSourcedId';
    private const USER_ID = 'userId';
    private const DELIVERY_ID = 'deliveryId';
    private const SCORERS_IDS = ['scorerId_1','scorerId_2'];
    private const TEST_RESULT = [];
    private const ITEM_RESULT = [];
    private const LOCALE = 'en_EN';
    private const PREV_TEST_RESULT = [];
    private const PREV_ITEM_RESULT = [];

    private ManualResultsMessage $subject;

    protected function setUp(): void
    {
        $this->subject = ManualResultsMessage::decode([
            'contextSourcedId' => self::CONTEXT_SOURCED_ID,
            'userId' => self::USER_ID,
            'deliveryId' => self::DELIVERY_ID,
            'scorersIds' => self::SCORERS_IDS,
            'testResult' => self::TEST_RESULT,
            'itemResult' => self::ITEM_RESULT,
            'locale' => self::LOCALE,
            'prevTestResult' => self::PREV_TEST_RESULT,
            'prevItemResult' => self::PREV_ITEM_RESULT,
        ]);
    }

    public function testDecode(): void
    {
        self::assertSame(self::CONTEXT_SOURCED_ID, $this->subject->getContextSourcedId());
        self::assertSame(self::USER_ID, $this->subject->getUserId());
        self::assertSame(self::DELIVERY_ID, $this->subject->getDeliveryId());
        self::assertSame(self::SCORERS_IDS, $this->subject->getScorersIds());
        self::assertSame(null, $this->subject->getTestResult());
        self::assertSame(self::ITEM_RESULT, $this->subject->getItemResults());
        self::assertNull($this->subject->getTestResult());
        self::assertSame(self::LOCALE, $this->subject->getLocale());
        self::assertNull($this->subject->getPrevItemResults());
        self::assertNull($this->subject->getPrevTestResult());

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
            'invalid-contextSourcedId' => [
                [
                    'contextSourcedId' => 123,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-contextSourcedId' => [
                [
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-userId' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => 123,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-userId' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-deliveryId' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => 123,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-deliveryId' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-testResult' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => 123,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-testResult' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-itemResult' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => 123,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-itemResult' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-scorersIds' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => 123,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'missing-scorersIds' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                ],
            ],
            'invalid-locale' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => 123,
                ],
            ],
            'invalid-prev-test-result' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                    'prevTestResult' => 123,
                ],
            ],
            'invalid-prev-item-results' => [
                [
                    'contextSourcedId' => self::CONTEXT_SOURCED_ID,
                    'userId' => self::USER_ID,
                    'deliveryId' => self::DELIVERY_ID,
                    'scorersIds' => self::SCORERS_IDS,
                    'testResult' => self::TEST_RESULT,
                    'itemResult' => self::ITEM_RESULT,
                    'locale' => self::LOCALE,
                    'prevItemResult' => 123,
                ],
            ],
        ];
    }

    public function testEncode(): void
    {
        $data = [
            'contextSourcedId' => self::CONTEXT_SOURCED_ID,
            'userId' => self::USER_ID,
            'deliveryId' => self::DELIVERY_ID,
            'scorersIds' => self::SCORERS_IDS,
            'testResult' => self::TEST_RESULT,
            'itemResult' => self::ITEM_RESULT,
            'locale'     => self::LOCALE,
            'prevTestResult' => null,
            'prevItemResult' => null,
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
