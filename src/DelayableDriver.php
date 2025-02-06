<?php

declare(strict_types=1);

namespace Bernard;

/**
 * @author Carlos Frutos <charly@workana.com>
 */
interface DelayableDriver extends Driver
{
    /**
     * Insert a message with delay in seconds.
     *
     * @param string $queueName
     * @param string $message
     * @param int $delay
     */
    public function pushMessageWithDelay($queueName, $message, $delay): void;
}
