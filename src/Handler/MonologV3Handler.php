<?php

/*
 * This file is part of the deprecations.io project.
 *
 * (c) Titouan Galopin <titouan@deprecations.io>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace DeprecationsIo\Monolog\Handler;

use Monolog\Handler\HandlerInterface;
use Monolog\LogRecord;

/**
 * Handler for Monolog 3.x
 */
class MonologV3Handler extends AbstractMonologHandler implements HandlerInterface
{
    /**
     * @param LogRecord $record
     * @return bool
     */
    protected function isRecordValid($record)
    {
        return isset($record->context['exception']) && $record->context['exception'] instanceof \Exception;
    }

    public function handle(LogRecord $record): bool
    {
        $this->handleBatch(array($record));

        return false;
    }

    public function handleBatch(array $records): void
    {
        $this->sendEventForRecords($records);
    }

    public function close(): void
    {
        // no-op (unused by deprecations.io)
    }

    public function isHandling(LogRecord $record): bool
    {
        // Always true to receive all records and accept them during handling
        return true;
    }
}
