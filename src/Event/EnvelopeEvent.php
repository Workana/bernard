<?php

declare(strict_types=1);

namespace Bernard\Event;

use Bernard\Envelope;
use Bernard\Queue;
use Symfony\Contracts\EventDispatcher\Event;

class EnvelopeEvent extends Event
{
    protected $envelope;
    protected $queue;

    public function __construct(Envelope $envelope, Queue $queue)
    {
        $this->envelope = $envelope;
        $this->queue = $queue;
    }

    /**
     * @return Envelope
     */
    public function getEnvelope()
    {
        return $this->envelope;
    }

    /**
     * @return Queue
     */
    public function getQueue()
    {
        return $this->queue;
    }
}
