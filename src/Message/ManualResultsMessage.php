<?php

// SPDX-FileCopyrightText: 2012-2026 Open Assessment Technologies S.A.
// Copyright (C) 2023-2025 (original work) Open Assessment Technologies SA;
//
// SPDX-License-Identifier: AGPL-3.0-only OR LicenseRef-TAO-Commercial-License

declare(strict_types=1);

namespace OAT\Library\GraderMessengerBridge\Message;

use Carbon\Carbon;
use InvalidArgumentException;
use OAT\Library\GraderMessengerBridge\Model\ItemResult;
use OAT\Library\GraderMessengerBridge\Model\OutcomeVariable;
use OAT\Library\GraderMessengerBridge\Model\TestResult;

class ManualResultsMessage implements SerializableMessage {
    
    /**
     * @param ItemResult[]  $itemResults
     */
    public function __construct(
        private readonly string $contextSourcedId,
        private readonly string $deliveryId,
        private readonly string $userId,
        private readonly array $scorersIds,
        private readonly ?TestResult $testResult,
        private readonly array $itemResults,
        private readonly ?string $locale = null,
        private readonly ?TestResult $prevTestResult = null,
        private readonly ?array $prevItemResults = null,
    ) { }
    
    public static function decode(array $data): self
    {
        foreach (['contextSourcedId', 'deliveryId', 'userId'] as $key) {
            if (!isset($data[$key]) || !is_string($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }
    
        foreach (['testResult', 'itemResult', 'scorersIds'] as $key) {
            if (!isset($data[$key]) || !is_array($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }

        if (isset($data['locale']) && !is_string($data['locale'])) {
            throw new InvalidArgumentException('Invalid `locale`, it must be string');
        }

        foreach (['prevTestResult', 'prevItemResult'] as $key) {
            if (isset($data[$key]) && !is_array($data[$key])) {
                throw new InvalidArgumentException(sprintf('Invalid `%s`', $key));
            }
        }
        
        return new static(
            $data['contextSourcedId'],
            $data['deliveryId'],
            $data['userId'],
            $data['scorersIds'],
            self::decodeTestResult($data['testResult']),
            self::decodeItemResults($data['itemResult']),
            $data['locale'] ?? null,
            !empty($data['prevTestResult']) ? self::decodeTestResult($data['prevTestResult']) : null,
            !empty($data['prevItemResult']) ? self::decodeItemResults($data['prevItemResult']) : null,
        );
    }
    
    private static function decodeTestResult(array $testResult): ?TestResult
    {
        if(empty($testResult)) {
            return null;
        }
        
        return new TestResult(
            $testResult['identifier'],
            Carbon::createFromFormat('Y-m-d\TH:i:s', $testResult['datestamp']),
            self::decodeOutcomeVariables($testResult['outcomeVariable'])
        );
    }

    private static function decodeItemResults(array $itemResults): array
    {
        return array_map(function(array $itemResult){
            return new ItemResult(
                $itemResult['identifier'],
                Carbon::createFromFormat('Y-m-d\TH:i:s', $itemResult['datestamp']),
                $itemResult['sessionStatus'],
                $itemResult['scorerId'],
                array_map(function($outcomeVariable){
                    return new OutcomeVariable(
                    $outcomeVariable['baseType'],
                    $outcomeVariable['cardinality'],
                    $outcomeVariable['identifier'],
                    $outcomeVariable['value']
                    );
                }, $itemResult['outcomeVariable'])
            );
        }, $itemResults);
    }
    
    private static function decodeOutcomeVariables(array $outcomeVariables): array
    {
        return array_map(function(array $outcomeVariable){
            return new OutcomeVariable(
                $outcomeVariable['baseType'],
                $outcomeVariable['cardinality'],
                $outcomeVariable['identifier'],
                $outcomeVariable['value']);
        }, $outcomeVariables);
    }
    
    public function encode(): array
    {
        return [
            'contextSourcedId' => $this->contextSourcedId,
            'userId' => $this->userId,
            'deliveryId' => $this->deliveryId,
            'scorersIds' => $this->scorersIds,
            'testResult' => $this->encodeTestResult($this->testResult),
            'itemResult' => $this->encodeItemResult($this->itemResults),
            'locale' => $this->locale,
            'prevTestResult' => $this->prevTestResult ? $this->encodeTestResult($this->prevTestResult) : null,
            'prevItemResult' => $this->prevItemResults ? $this->encodeItemResult($this->prevItemResults) : null,
        ];
    }
    
    private function encodeTestResult(?TestResult $testResult): array
    {
        if(null === $testResult) {
            return [];
        }
        
        return [
            'identifier' => $testResult->getId(),
            'datestamp' => $testResult->getDateStamp(),
            'outcomeVariable' => $this->encodeOutcomeVariables($testResult->getOutcomeVariables())
        ];
    }
    
    /**
     * @param ItemResult[] $itemResults
     */
    private function encodeItemResult(array $itemResults): array
    {
       $itemResultsEncoded = [];
       
       foreach ($itemResults as $itemResult) {
           $itemResultsEncoded[] = [
                "datestamp" => $itemResult->getDateStamp(),
                "identifier" => $itemResult->getId(),
                "sessionStatus" => $itemResult->getSessionStatus(),
                "scorerId" => $itemResult->getScorerId(),
                "outcomeVariable" => $this->encodeOutcomeVariables($itemResult->getOutcomeVariables())
           ];
       }
       
       return $itemResultsEncoded;
    }
    
    /**
     * @param OutcomeVariable[] $outcomeVariables
     */
    private function encodeOutcomeVariables(array $outcomeVariables): array
    {
        $outcomeVariablesEncoded = [];

        foreach ($outcomeVariables as $outcomeVariable) {
            $outcomeVariablesEncoded[] = [
                "baseType" => $outcomeVariable->getBaseType(),
                "cardinality" => $outcomeVariable->getCardinality(),
                "identifier" => $outcomeVariable->getId(),
                "value" => $outcomeVariable->getValue()
             ];
        }
        
        return $outcomeVariablesEncoded;
    }

    public function getContextSourcedId(): string
    {
        return $this->contextSourcedId;
    }

    public function getDeliveryId(): string
    {
        return $this->deliveryId;
    }

    public function getUserId(): string
    {
        return $this->userId;
    }

    public function getScorersIds(): array
    {
        return $this->scorersIds;
    }

    public function getLocale(): ?string
    {
        return $this->locale;
    }
    
    public function getTestResult(): ?TestResult
    {
        return $this->testResult;
    }
    
    /**
     * @return ItemResult[] $outcomeVariables
     */
    public function getItemResults(): array
    {
        return $this->itemResults;
    }

    public function getPrevTestResult(): ?TestResult
    {
        return $this->prevTestResult;
    }

    /**
     * @return ?ItemResult[] $outcomeVariables
     */
    public function getPrevItemResults(): ?array
    {
        return $this->prevItemResults;
    }
}
