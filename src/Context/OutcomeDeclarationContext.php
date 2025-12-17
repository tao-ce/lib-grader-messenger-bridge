<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Context;

use JsonSerializable;
use OAT\Library\GraderMessengerBridge\Context\Exception\ContextInvalidArgumentException;

final class OutcomeDeclarationContext implements JsonSerializable
{
    private string $outcomeDeclarationId;
    private ?int $score;
    private ?string $scale = null;

    public function __construct(string $outcomeDeclarationId, ?int $score)
    {
        if ('' === trim($outcomeDeclarationId)) {
            throw ContextInvalidArgumentException::invalidOutcomeDeclarationId();
        }

        $this->outcomeDeclarationId = $outcomeDeclarationId;
        $this->score = $score;
    }

    public function setScale(string $scale): void
    {
        if ('' === trim($scale)) {
            throw ContextInvalidArgumentException::invalidScale();
        }

        $this->scale = $scale;
    }


    public function jsonSerialize(): array
    {
        $serialized =  [
            'outcomeDeclarationId' => $this->outcomeDeclarationId,
            'score' => $this->score,
        ];

        if (!empty($this->scale)) {
            $serialized['scale'] = $this->scale;
        }

        return $serialized;
    }
}
