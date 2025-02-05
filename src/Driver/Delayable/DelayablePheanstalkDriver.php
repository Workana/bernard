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
    /**
     * {@inheritDoc}
     */
    public function pushMessageWithDelay($queueName, $message, $delay): void
    {
        $this->pheanstalk->putInTube(
            $queueName,
            $message,
            PheanstalkInterface::DEFAULT_PRIORITY,
            (int) $delay
        );
    }
}
