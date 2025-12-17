<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event\ScoringEvent;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\AbstractTenantAwareMessage;
use OAT\Library\GraderMessengerBridge\Message\SerializableMessage;


abstract class AbstractScoringEvent extends AbstractTenantAwareMessage implements SerializableMessage, ScoringEventMessageInterface
{
    protected const KEY_TENANT_ID = 'tenantId';
    protected const KEY_DELIVERY_EXECUTION_ID = 'deliveryExecutionId';
    protected const KEY_EVENT_NAME = 'eventName';

    public function __construct(
        string $tenantId,
        protected string $deliveryExecutionId,
    )
    {
        parent::__construct($tenantId);
    }

    abstract public function getScoringEventName(): string;

    public function getDeliveryExecutionId(): string
    {
        return $this->deliveryExecutionId;
    }

    public static function decode(array $data): SerializableMessage
    {
        // TODO: Implement decode() method.
    }

    public function encode(): array
    {
        return [
            self::KEY_TENANT_ID => $this->tenantId,
            self::KEY_EVENT_NAME => $this->getScoringEventName(),
            self::KEY_DELIVERY_EXECUTION_ID => $this->deliveryExecutionId,
        ];
    }
}