<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Validator;

use InvalidArgumentException;

trait ArgumentValidatorTrait
{
    protected static function validateRequiredString(array $data, string $key): void
    {
        if (!isset($data[$key]) || !is_string($data[$key]) || '' === trim($data[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument `%s`', $key));
        }
    }

    protected static function validateOptionalString(array $data, string $key): void
    {
        if (isset($data[$key]) && (!is_string($data[$key]) || '' === trim($data[$key]))) {
            throw new InvalidArgumentException(sprintf('Invalid argument `%s`', $key));
        }
    }

    protected static function validateRequiredInt(array $data, string $key): void
    {
        if (!isset($data[$key]) || !is_int($data[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument `%s`', $key));
        }
    }

    protected static function validateRequiredBool(array $data, string $key): void
    {
        if (!isset($data[$key]) || !is_bool($data[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument `%s`', $key));
        }
    }

    protected static function validateOptionalBool(array $data, string $key): void
    {
        if (isset($data[$key]) && !is_bool($data[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument `%s`', $key));
        }
    }

    protected static function validateRequiredArray(array $data, string $key): void
    {
        if (!isset($data[$key]) || !is_array($data[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument `%s`', $key));
        }
    }

    protected static function validateOptionalArray(array $data, string $key): void
    {
        if (isset($data[$key]) && !is_array($data[$key])) {
            throw new InvalidArgumentException(sprintf('Invalid argument `%s`', $key));
        }
    }
}