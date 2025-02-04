<?php

declare(strict_types=1);

namespace Bernard\Tests;

use Bernard\Message\PlainMessage;
use Bernard\Envelope;

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

    public function testNotDelayedMetadata()
    {
        $envelope = new Envelope($message = new PlainMessage('SendNewsletter'));
        $this->assertFalse($envelope->isDelayed());
        $this->assertEquals(0, $envelope->getDelay());
    }

    public function testDelayedMetadata()
    {
        $envelope = new Envelope($message = new PlainMessage('SendNewsletter'), 10);
        $this->assertTrue($envelope->isDelayed());
        $this->assertEquals(10, $envelope->getDelay());
    }

    /**
     * @expectedException Bernard\Exception\InvalidOperationException
     * @expectedExceptionMessage Delay must be greater or equal than zero
     */
    public function testNegativeDelay()
    {
        $envelope = new Envelope($message = new PlainMessage('SendNewsletter'), -10);
    }
}
