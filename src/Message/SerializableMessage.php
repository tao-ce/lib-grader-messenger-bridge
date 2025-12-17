<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2022 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message;

use InvalidArgumentException;

interface SerializableMessage
{
    /** @throws InvalidArgumentException */
    public static function decode(array $data): self;

    public function encode(): array;
}
