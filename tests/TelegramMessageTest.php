<?php

namespace NotificationChannels\Sens\Test;

use NotificationChannels\Sens\SensMessage;

class SensMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_accepts_content_when_constructed()
    {
        $message = new SensMessage('Laravel Notification Channels are awesome!');
        $this->assertEquals('Laravel Notification Channels are awesome!', $message->payload['content']);
    }



}
