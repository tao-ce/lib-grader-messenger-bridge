<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Model;

use Carbon\Carbon;

final class TestResult
{
    /**
     * @param OutcomeVariable[]  $outcomeVariables
     */
    public function __construct(
        private string $id,
        private Carbon $createdAt,
        private array $outcomeVariables,
    ) {
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getDateStamp(): string
    {
        return $this->createdAt->format('Y-m-d\TH:i:s');
    }
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
    
    public function getOutcomeVariables(): array
    {
        return $this->outcomeVariables;
    }
}
