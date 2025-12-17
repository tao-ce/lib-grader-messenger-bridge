<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Context;

use JsonSerializable;
use OAT\Library\GraderMessengerBridge\Context\Exception\ContextInvalidArgumentException;

readonly class ScoreContext implements JsonSerializable
{
    public function __construct(
        private string $elementId,
        private bool $isTestLevel,
        private OutcomeDeclarationContextCollection $outcomeDeclarations
    ) {
        if ('' === trim($elementId)) {
            throw ContextInvalidArgumentException::invalidElementId();
        }
    }

    public function jsonSerialize(): array
    {
        return [
            'elementId' => $this->elementId,
            'isTestLevel' => $this->isTestLevel,
            'outcomeDeclarations' => $this->outcomeDeclarations->jsonSerialize(),
        ];
    }
}
