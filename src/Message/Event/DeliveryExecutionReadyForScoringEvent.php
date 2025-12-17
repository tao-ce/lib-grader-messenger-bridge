<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event;

use OAT\Library\GraderMessengerBridge\Interface\ExternalMessageInterface;
use \OAT\Library\GraderMessengerBridge\Message\AbstractTenantAwareMessage;
use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\SerializableMessage;

class DeliveryExecutionReadyForScoringEvent extends AbstractTenantAwareMessage implements SerializableMessage, ExternalMessageInterface
{
    public function __construct(
        string $tenantId,
        private readonly string $engineName,
        private readonly string $deliveryExecutionId,
        private readonly ?string $enrollmentRole = null
    ) {
        parent:: __construct($tenantId);
    }

    public static function decode(array $data): self
    {
        foreach (['tenantId', 'engineName', 'deliveryExecutionId', 'enrollmentRole'] as $key) {
            if (!isset($data[$key]) || !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }

        return new self(
            $data['tenantId'],
            $data['engineName'],
            $data['deliveryExecutionId'],
            $data['enrollmentRole'],
        );
    }

    public function encode(): array
    {
        return [
            'tenantId' => $this->tenantId,
            'engineName' => $this->engineName,
            'deliveryExecutionId' => $this->deliveryExecutionId,
            'enrollmentRole' => $this->enrollmentRole,
        ];
    }

    public function getEngineName(): string
    {
        return $this->deliveryExecutionId;
    }

    public function getDeliveryExecutionId(): string
    {
        return $this->deliveryExecutionId;
    }

    public function getEnrollmentRole(): ?string
    {
        return $this->enrollmentRole;
    }
}
