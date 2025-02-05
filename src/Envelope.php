<?php

declare(strict_types=1);

namespace Bernard;

use Bernard\Exception\InvalidOperationException;

/**
 * Wraps a Message with metadata that can be used for automatic retry
 * or inspection.
 */
final class Envelope
{
    private $message;
    private $class;
    private $timestamp;

    private int $delay;

    public function __construct(Message $message, int $delay = 0)
    {
        if ((int) $delay < 0) {
            throw new InvalidOperationException('Delay must be greater or equal than zero');
        }

        $this->message = $message;
        $this->delay  = $delay;
        $this->class = get_class($message);
        $this->timestamp = time();
    }

    /**
     * @return Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return bool
     */
    public function isDelayed()
    {
        return ($this->delay > 0);
    }

    /**
     * @return int
     */
    public function getDelay()
    {
        return $this->delay;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->message->getName();
    }

    /**
     * @return string
     */
    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return int
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }
}
