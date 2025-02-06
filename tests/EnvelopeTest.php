<?php

declare(strict_types=1);

namespace Bernard\Tests;

use Bernard\Envelope;
use Bernard\Exception\InvalidOperationException;
use Bernard\Message\PlainMessage;

final class EnvelopeTest extends \PHPUnit\Framework\TestCase
{
    public function testItWrapsAMessageWithMetadata(): void
    {
        $envelope = new Envelope($message = new PlainMessage('SendNewsletter'));

        $this->assertEquals(time(), $envelope->getTimestamp());
        $this->assertEquals(PlainMessage::class, $envelope->getClass());
        $this->assertEquals('SendNewsletter', $envelope->getName());
        $this->assertSame($message, $envelope->getMessage());
    }

    public function testNotDelayedMetadata(): void
    {
        $envelope = new Envelope($message = new PlainMessage('SendNewsletter'));
        $this->assertFalse($envelope->isDelayed());
        $this->assertEquals(0, $envelope->getDelay());
    }

    public function testDelayedMetadata(): void
    {
        $envelope = new Envelope($message = new PlainMessage('SendNewsletter'), 10);
        $this->assertTrue($envelope->isDelayed());
        $this->assertEquals(10, $envelope->getDelay());
    }

    public function testNegativeDelay(): void
    {
        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage('Delay must be greater or equal than zero');

        new Envelope(new PlainMessage('SendNewsletter'), -10);
    }
}
