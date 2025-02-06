<?php

declare(strict_types=1);

namespace Bernard;

use Bernard\Event\EnvelopeEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Producer
{
    protected $queues;
    protected $dispatcher;

    public function __construct(QueueFactory $queues, EventDispatcherInterface $dispatcher)
    {
        $this->queues = $queues;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param string|null $queueName
     * @param int    $delay    Delay (in seconds)
     */
    public function produce(Message $message, $queueName = null, int $delay = 0): void
    {
        $queueName = $queueName ?: Util::guessQueue($message);

        $queue = $this->queues->create($queueName);
        $queue->enqueue($envelope = new Envelope($message, $delay));

        $this->dispatcher->dispatch(new EnvelopeEvent($envelope, $queue), BernardEvents::PRODUCE);
    }

    private function dispatch($eventName, EnvelopeEvent $event): void
    {
        $this->dispatcher->dispatch($event, $eventName);
    }
}
