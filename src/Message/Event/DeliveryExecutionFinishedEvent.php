<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event;

use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Interface\ExternalMessageInterface;
use OAT\Library\GraderMessengerBridge\Message\AbstractTenantAwareMessage;
use OAT\Library\GraderMessengerBridge\Message\SerializableMessage;

class DeliveryExecutionFinishedEvent extends AbstractTenantAwareMessage implements DeliveryExecutionFinishedEventInterface, SerializableMessage, ExternalMessageInterface
{
    public function __construct(
        string $tenantId,
        private readonly string $deliveryId,
        private readonly string $deliveryExecutionId,
        private readonly string $testTakerId,
        private readonly array $testTakerGroupIds,
        private readonly ?string $clientId,
        private readonly ?string $originalIssuer,
        private readonly ?array $ags,
        private readonly int $attempt = 1,
        private readonly ?string $locale = null,
    ) {
        parent::__construct($tenantId);
    }

    public static function decode(array $data): self
    {
        foreach ([ 'tenantId', 'deliveryId', 'deliveryExecutionId', 'testTakerId'] as $key) {
            if (!isset($data[$key]) || !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }

        if (!isset($data['testTakerGroupIds']) || !is_array($data['testTakerGroupIds'])) {
            throw new InvalidArgumentException('Invalid `testTakerGroupIds`');
        }

        foreach (['clientId', 'originalIssuer'] as $key) {
            if (isset($data[$key]) && !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }

        if (isset($data['ags']) && !is_array($data['ags'])) {
            throw new InvalidArgumentException('Invalid `ags`');
        }

        if (isset($data['attempt']) && !is_int($data['attempt'])) {
            throw new InvalidArgumentException('Invalid `attempt`');
        }

        if (isset($data['locale']) && !is_string($data['locale'])) {
            throw new InvalidArgumentException('Invalid `locale`');
        }

        return new static(
            $data['tenantId'],
            $data['deliveryId'],
            $data['deliveryExecutionId'],
            $data['testTakerId'],
            $data['testTakerGroupIds'],
            $data['clientId'] ?? null,
            $data['originalIssuer'] ?? null,
            $data['ags'] ?? null,
            $data['attempt'] ?? 1,
            $data['locale'] ?? null,
        );
    }

    public function encode(): array
    {
        $data = [
            'tenantId' => $this->tenantId,
            'deliveryId' => $this->deliveryId,
            'deliveryExecutionId' => $this->deliveryExecutionId,
            'testTakerId' => $this->testTakerId,
            'testTakerGroupIds' => $this->testTakerGroupIds,
            'attempt' => $this->attempt,
            'locale' => $this->locale,
        ];

        if (null !== $this->clientId) {
            $data['clientId'] = $this->clientId;
        }

        if (null !== $this->originalIssuer) {
            $data['originalIssuer'] = $this->originalIssuer;
        }

        if (null !== $this->ags) {
            $data['ags'] = $this->ags;
        }

        return $data;
    }

    public function getDeliveryId(): string
    {
        return $this->deliveryId;
    }

    public function getDeliveryExecutionId(): string
    {
        return $this->deliveryExecutionId;
    }

    public function getTestTakerId(): string
    {
        return $this->testTakerId;
    }

    public function getTestTakerGroupIds(): array
    {
        return $this->testTakerGroupIds;
    }

    public function getClientId(): ?string
    {
        return $this->clientId;
    }

    public function getOriginalIssuer(): ?string
    {
        return $this->originalIssuer;
    }

    public function getAgs(): ?array
    {
        return $this->ags;
    }

    public function getAttempt(): int
    {
        return $this->attempt;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }
}
