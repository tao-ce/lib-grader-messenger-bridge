<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Command;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\AbstractTenantAwareMessage;
use OAT\Library\GraderMessengerBridge\Message\SerializableMessage;

class CreateDeliveryCommand extends AbstractTenantAwareMessage implements SerializableMessage
{
    public function __construct(
        string $tenantId,
        private readonly string $deliveryId,
        private readonly string $testTitle,
        private readonly string $testQtiIdentifier,
        private readonly int $receivedAt,
        private readonly array $items,
        private readonly array $test,
        private readonly string $engineName
    ) {
        parent::__construct($tenantId);
    }

    public static function decode(array $data): self
    {
        foreach (['tenantId', 'deliveryId', 'testTitle', 'testQtiIdentifier', 'engineName'] as $key) {
            if (!isset($data[$key]) || !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }

        if (!isset($data['receivedAt']) || !is_integer($data['receivedAt'])) {
            throw new InvalidArgumentException('Invalid `receivedAt`');
        }

        if (!isset($data['items']) || !is_array($data['items'])) {
            throw new InvalidArgumentException('Invalid `items`');
        }

        if (isset($data['test']) && !is_array($data['test'])) {
            throw new InvalidArgumentException('Invalid `test`');
        }

        return new static(
            $data['tenantId'],
            $data['deliveryId'],
            $data['testTitle'],
            $data['testQtiIdentifier'],
            $data['receivedAt'],
            $data['items'],
            $data['test'],
            $data['engineName']
        );
    }

    public function encode(): array
    {
        return [
            'tenantId' => $this->tenantId,
            'deliveryId' => $this->deliveryId,
            'testTitle' => $this->testTitle,
            'testQtiIdentifier' => $this->testQtiIdentifier,
            'receivedAt' => $this->receivedAt,
            'items' => $this->items,
            'test' => $this->test,
            'engineName' => $this->engineName
        ];
    }

    public function getDeliveryId(): string
    {
        return $this->deliveryId;
    }

    public function getTestTitle(): string
    {
        return $this->testTitle;
    }

    public function getTestQtiIdentifier(): string
    {
        return $this->testQtiIdentifier;
    }

    public function getReceivedAt(): int
    {
        return $this->receivedAt;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getTest(): array
    {
        return $this->test;
    }

    public function getEngineName(): string
    {
        return $this->engineName;
    }
}
