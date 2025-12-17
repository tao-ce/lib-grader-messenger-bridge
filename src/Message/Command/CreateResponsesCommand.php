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

class CreateResponsesCommand extends AbstractTenantAwareMessage implements SerializableMessage
{
    public function __construct(
        string $tenantId,
        private readonly string $deliveryId,
        private readonly string $deliveryExecutionId,
        private readonly string $testTakerId,
        private readonly string $engineName,
        private readonly ?string $testTakerGroupId,
        private readonly ?array $responses,
        private readonly ?array $testResponse,
        private readonly int $attempt = 1,
        private readonly ?string $locale = null,
    ) {
        parent::__construct($tenantId);
    }

    public static function decode(array $data): self
    {
        foreach (['tenantId', 'deliveryId', 'deliveryExecutionId', 'testTakerId', 'engineName'] as $key) {
            if (!isset($data[$key]) || !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }

        if (isset($data['testTakerGroupId']) && !is_string($data['testTakerGroupId'])) {
            throw new InvalidArgumentException('Invalid `testTakerGroupId`');
        }

        if (isset($data['responses']) && !is_array($data['responses'])) {
            throw new InvalidArgumentException('Invalid `responses`');
        }

        if (isset($data['attempt']) && !is_int($data['attempt'])) {
            throw new InvalidArgumentException('Invalid `attempt`');
        }

        if (isset($data['locale']) && !is_string($data['locale'])) {
            throw new InvalidArgumentException('Invalid `locale`');
        }

        if (isset($data['testResponse']) && !is_array($data['testResponse'])) {
            throw new InvalidArgumentException('Invalid `testResponse`');
        }

        return new static(
            $data['tenantId'],
            $data['deliveryId'],
            $data['deliveryExecutionId'],
            $data['testTakerId'],
            $data['engineName'],
            $data['testTakerGroupId'] ?? null,
            $data['responses'] ?? null,
            $data['testResponse'] ?? null,
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
            'engineName' => $this->engineName,
            'attempt' => $this->attempt,
            'locale' => $this->locale,
        ];

        if (null !== $this->testTakerGroupId) {
            $data['testTakerGroupId'] = $this->testTakerGroupId;
        }

        if (null !== $this->responses) {
            $data['responses'] = $this->responses;
        }

        if (null !== $this->testResponse) {
            $data['testResponse'] = $this->testResponse;
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

    public function getTestTakerGroupId(): ?string
    {
        return $this->testTakerGroupId;
    }

    public function getResponses(): ?array
    {
        return $this->responses;
    }

    public function getEngineName(): string
    {
        return $this->engineName;
    }

    public function getAttempt(): int
    {
        return $this->attempt;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }

    public function getTestResponse(): ?array
    {
        return $this->testResponse;
    }
}
