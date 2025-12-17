<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2020-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Context\Exception;

use InvalidArgumentException;

class ContextInvalidArgumentException extends InvalidArgumentException
{
    public static function invalidScores(): self
    {
        return new self("Scores can't be empty");
    }

    public static function invalidElementId(): self
    {
        return new self("Element ID can't be empty");
    }

    public static function invalidDeliveryId(): self
    {
        return new self("Delivery ID can't be empty");
    }

    public static function invalidDeliveryExecutionId(): self
    {
        return new self("DeliveryExecution ID can't be empty");
    }

    public static function invalidAttemptNumber(): self
    {
        return new self("Attempt number can't be `0`");
    }

    public static function invalidScorerId(): self
    {
        return new self("Scorer ID can't be empty");
    }

    public static function invalidOutcomeDeclarations(): self
    {
        return new self("OutcomeDeclarations can't be empty");
    }

    public static function invalidOutcomeDeclarationId(): self
    {
        return new self("OutcomeDeclaration ID can't be empty");
    }

    public static function invalidScore(): self
    {
        return new self("Score value cant be `NULL` without NotEnoughBasisForAssessmentFlag");
    }

    public static function invalidScale(): self
    {
        return new self("Scale value can't be empty");
    }
    public static function invalidScaleValue(int $int): self
    {
        return new self(sprintf('%s is not a valid scale map key', $int));
    }
}
