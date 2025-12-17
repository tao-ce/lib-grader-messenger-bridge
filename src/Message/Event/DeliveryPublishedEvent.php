<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event;

use OAT\Library\GraderMessengerBridge\Interface\ExternalMessageInterface;
use \OAT\Library\GraderMessengerBridge\Message\AbstractTenantAwareMessage;
use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Message\SerializableMessage;

class DeliveryPublishedEvent extends AbstractTenantAwareMessage implements SerializableMessage, DeliveryPublishedEventInterface, ExternalMessageInterface
{
    public function __construct(
        string $tenantId,
        private readonly string $deliveryId,
        private readonly array $configuration = [],
        private readonly ?string $locale = null,
    ) {
        parent:: __construct($tenantId);
    }

    public static function decode(array $data): self
    {
        foreach (['tenantId', 'deliveryId'] as $key) {
            if (!isset($data[$key]) || !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }

        if (isset($data['configuration']) && !is_array($data['configuration'])) {
            throw new InvalidArgumentException('Invalid `configuration`');
        }

        if (isset($data['locale']) && !is_string($data['locale'])) {
            throw new InvalidArgumentException('Invalid `locale`, it must be string');
        }

        return new self(
            $data['tenantId'],
            $data['deliveryId'],
            $data['configuration'] ?? [],
            $data['locale'] ?? null,
        );
    }

    public function encode(): array
    {
        return [
            'tenantId' => $this->tenantId,
            'deliveryId' => $this->deliveryId,
            'configuration' => $this->configuration,
            'locale' => $this->locale,
        ];
    }

    public function getDeliveryId(): string
    {
        return $this->deliveryId;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }
}
