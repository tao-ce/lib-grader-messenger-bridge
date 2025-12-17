<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\ProviderAwareMessage;
use OAT\Library\GraderMessengerBridge\Message\SerializableMessage;
use PHPUnit\Framework\TestCase;

abstract class PlagiarismStatusMessageTest extends TestCase
{
    private const ID = 'id';
    private const CREATED_AT = '2023-01-27T01:36:18+0000';
    private const ASSESSMENT_ID = 'assessmentId';
    private const ITEM_ID = 'itemId';
    private const RESPONSE_ID = 'responseId';
    private const STATUS = 'status';
    private const HREF = 'href';

    protected SerializableMessage|ProviderAwareMessage $subject;

    protected function setUpTest($messageName): void
    {
        $this->subject = $messageName::decode([
            'id' => self::ID,
            'createdAt' => self::CREATED_AT,
            'assessmentId' => self::ASSESSMENT_ID,
            'itemId' => self::ITEM_ID,
            'responseId' => self::RESPONSE_ID,
            'status' => self::STATUS,
            'href' => self::HREF,
        ]);
    }

    public function testDecode(): void
    {
        self::assertSame(self::ID, $this->subject->getId());
        self::assertSame(self::CREATED_AT, $this->subject->getCreatedAtFormatted());
        self::assertSame(self::ASSESSMENT_ID, $this->subject->getAssessmentId());
        self::assertSame(self::ITEM_ID, $this->subject->getItemId());
        self::assertSame(self::RESPONSE_ID, $this->subject->getResponseId());
        self::assertSame(self::STATUS, $this->subject->getStatus());
        self::assertSame(self::HREF, $this->subject->getHref());
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
            'invalid-id' => [
                [
                    'id' => 123,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'missing-id' => [
                [
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'invalid-created-at' => [
                [
                    'id' => self::ID,
                    'createdAt' => 123,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'missing-created-at' => [
                [
                    'id' => self::ID,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'invalid-assessment-id' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => 123,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'missing-assessment-id' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'invalid-item-id' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => 123,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'missing-item-id' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'invalid-response-id' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => 123,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'missing-response-id' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'status' => self::STATUS,
                    'href' => self::HREF,
                ],
            ],
            'invalid-status' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => 123,
                    'href' => self::HREF,
                ],
            ],
            'missing-status' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'href' => self::HREF,
                ],
            ],
            'invalid-href' => [
                [
                    'id' => self::ID,
                    'createdAt' => self::CREATED_AT,
                    'assessmentId' => self::ASSESSMENT_ID,
                    'itemId' => self::ITEM_ID,
                    'responseId' => self::RESPONSE_ID,
                    'status' => self::STATUS,
                    'href' => 123,
                ],
            ],
        ];
    }

    public function testEncode(): void
    {
        $data = [
            'id' => self::ID,
            'createdAt' => self::CREATED_AT,
            'assessmentId' => self::ASSESSMENT_ID,
            'itemId' => self::ITEM_ID,
            'responseId' => self::RESPONSE_ID,
            'status' => self::STATUS,
            'href' => self::HREF,
        ];

        self::assertSame($data, $this->subject->encode());
    }
}
