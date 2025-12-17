<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Model;

class OutcomeVariable
{
    public function __construct(
        private string $baseType,
        private string $cardinality,
        private string $id,
        private string $value
    ) {
    }
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getValue(): string
    {
        return $this->value;
    }
    
    public function getBaseType(): string
    {
        return $this->baseType;
    }
    
    public function getCardinality(): string
    {
        return $this->cardinality;
    }
}
