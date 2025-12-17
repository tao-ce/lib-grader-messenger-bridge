<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Context;

use JsonSerializable;
final class ScoreContextCollection implements JsonSerializable
{
    /** @var ScoreContext[] */
    private array $scores;

    public function addScoreContext(ScoreContext $scoreContext): void
    {
        $this->scores[] = $scoreContext;
    }

    public function getScores(): array
    {
        return $this->scores;
    }

    public function jsonSerialize(): array
    {
        return array_map(
            static function (ScoreContext $score): array {
                return $score->jsonSerialize();
            },
            $this->scores
        );
    }
}
