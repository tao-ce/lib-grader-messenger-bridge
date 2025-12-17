<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message\Event;

interface DeliveryExecutionFinishedEventInterface
{

    public function getDeliveryId(): string;

    public function getDeliveryExecutionId(): string;

    public function getTestTakerId(): string;

    public function getTestTakerGroupIds(): array;

    public function getClientId(): ?string;

    public function getOriginalIssuer(): ?string;

    public function getAgs(): ?array;

    public function getAttempt(): int;

    public function getLocale(): ?string;
}
