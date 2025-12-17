<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Tests\Unit\Message;

use OAT\Library\GraderMessengerBridge\Message\HblPlagiarismStatusMessage;

class HblPlagiarismStatusMessageTest extends PlagiarismStatusMessageTest
{
    private const PROVIDER = 'hbl';
    
    protected function setUp(): void
    {
        $this->setUpTest(HblPlagiarismStatusMessage::class);
    }
    
    public function testGetProvider(): void
    {
        self::assertSame($this->subject->getProvider(), self::PROVIDER);
    }
}
