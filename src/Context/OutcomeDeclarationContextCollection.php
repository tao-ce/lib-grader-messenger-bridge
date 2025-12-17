<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Context;

use JsonSerializable;
final class OutcomeDeclarationContextCollection implements JsonSerializable
{
    /** @var OutcomeDeclarationContext[] */
    private array $outcomeDeclarations = [];

    public function addOutcomeDeclaration(OutcomeDeclarationContext $outcomeDeclaration): void
    {
        $this->outcomeDeclarations[] = $outcomeDeclaration;
    }

    public function getOutcomeDeclarations(): array
    {
        return $this->outcomeDeclarations;
    }

    public function jsonSerialize(): array
    {
        return array_map(
            static function (OutcomeDeclarationContext $outcomeDeclaration): array {
                return $outcomeDeclaration->jsonSerialize();
            },
            $this->outcomeDeclarations
        );
    }
}
