<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message;

use Carbon\Carbon;
use InvalidArgumentException;

abstract class PlagiarismStatusMessage implements SerializableMessage
{
    public function __construct(
        private readonly string $id,
        private readonly Carbon $createdAt,
        private readonly string $assessmentId,
        private readonly string $itemId,
        private readonly string $responseId,
        private readonly string $status,
        private readonly ?string $href = null,
    ) { }
    
    abstract public function getProvider(): string;
    
    public static function decode(array $data): self
    {
        foreach (['id', 'createdAt', 'assessmentId', 'itemId', 'responseId', 'status'] as $key) {
            if (!isset($data[$key]) || !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }
        
        if(isset($data['href'])) {
            if(!is_string($data['href'])){
                throw new InvalidArgumentException(sprintf('Invalid `%s`', 'href'));
            }
        } else {
            $data['href'] = null;
        }
        
        return new static(
            $data['id'],
            Carbon::createFromFormat('Y-m-d\TH:i:sO', $data['createdAt']),
            $data['assessmentId'],
            $data['itemId'],
            $data['responseId'],
            $data['status'],
            $data['href']
        );
    }
    
    public function encode(): array
    {
        return [
            'id' => $this->id,
            'createdAt' => $this->createdAt->format('Y-m-d\TH:i:sO'),
            'assessmentId' => $this->assessmentId,
            'itemId' => $this->itemId,
            'responseId' => $this->responseId,
            'status' => $this->status,
            'href' => $this->href
        ];
    }
    
    public function getId(): string
    {
        return $this->id;
    }
    
    public function getCreatedAt(): Carbon
    {
        return $this->createdAt;
    }
    
    public function getCreatedAtFormatted(): string
    {
        return $this->createdAt->format('Y-m-d\TH:i:sO');
    }
    
    public function getAssessmentId(): string
    {
        return $this->assessmentId;
    }
    
    public function getItemId(): string
    {
        return $this->itemId;
    }
    
    public function getResponseId(): string
    {
        return $this->responseId;
    }
    
    public function getStatus(): string
    {
        return $this->status;
    }
    
    public function getHref(): ?string
    {
        return $this->href;
    }
}
