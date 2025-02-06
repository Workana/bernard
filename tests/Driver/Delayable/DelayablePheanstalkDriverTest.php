<?php
declare(strict_types=1);

namespace Bernard\Tests\Driver\Delayable;

use Bernard\Driver\Delayable\DelayablePheanstalkDriver;
use PHPUnit\Framework\TestCase;

class DelayablePheanstalkDriverTest extends TestCase
{
    protected function setUp(): void
    {
        $this->pheanstalk = $this->getMockBuilder('Pheanstalk\PheanstalkInterface')
            ->setMethods([
                'putInTube'
            ])
            ->disableOriginalConstructor()
            ->getMock();

        $this->driver = new DelayablePheanstalkDriver($this->pheanstalk);
    }

    public function testItPushesMessagesWithDelay(): void
    {
        $this->pheanstalk
            ->expects($this->once())
            ->method('putInTube')
            ->with(
                $this->equalTo('my-queue'),
                $this->equalTo('This is a message'),
                $this->equalTo(DelayablePheanstalkDriver::DEFAULT_PRIORITY),
                $this->equalTo(10)
            );

        $this->driver->pushMessageWithDelay('my-queue', 'This is a message', 10);
    }
}
