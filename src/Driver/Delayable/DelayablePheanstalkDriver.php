<?php

declare(strict_types=1);

namespace Bernard\Driver\Delayable;

use Bernard\DelayableDriver;
use Bernard\Driver\Pheanstalk;

/**
 * Delayable Pheanstalk Driver.
 *
 * @author Carlos Frutos <charly@workana.com>
 */
class DelayablePheanstalkDriver extends Pheanstalk\Driver implements DelayableDriver
{
    public const DEFAULT_PRIORITY = 1024; // most urgent: 0, least urgent: 4294967295

    /**
     * {@inheritDoc}
     */
    public function pushMessageWithDelay($queueName, $message, $delay): void
    {
        $this->pheanstalk->putInTube(
            $queueName,
            $message,
            self::DEFAULT_PRIORITY,
            (int) $delay
        );
    }
}
