<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message;

use InvalidArgumentException;

abstract class AbstractTenantAwareMessage
{
    protected readonly string $tenantId;

    public function __construct(string $tenantId)
    {
        if (empty($tenantId)) {
            throw new InvalidArgumentException('Tenant ID cannot be empty');
        }

        $this->tenantId = $tenantId;
    }

    public function getTenantId(): string
    {
        return $this->tenantId;
    }
}
