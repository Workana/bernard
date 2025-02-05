<?php
namespace Bernard\Driver\Delayable;

use Bernard\Driver\Pheanstalk;
use Bernard\DelayableDriver;
use Pheanstalk\PheanstalkInterface;

/**
 * Delayable Pheanstalk Driver
 *
 * @package Bernard
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
