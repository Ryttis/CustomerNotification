<?php

namespace App\Tests\Unit;

use App\Model\Message;
use App\Service\SMSSender;
use PHPUnit\Framework\TestCase;

class SMSSenderTest extends TestCase
{
    public function testSupportsReturnsTrueForSMSType(): void
    {
        $smsSender = new SMSSender();
        $message = new Message();
        $message->setType(Message::TYPE_SMS);

        $this->assertTrue($smsSender->supports($message));
    }

    public function testSupportsReturnsFalseForNonSMSType(): void
    {
        $smsSender = new SMSSender();
        $message = new Message();
        $message->setType(Message::TYPE_EMAIL);

        $this->assertFalse($smsSender->supports($message));
    }

    public function testSendOutputsSMS(): void
    {
        $smsSender = new SMSSender();
        $message = new Message();
        $message->setType(Message::TYPE_SMS);

        $this->expectOutputString('SMS');
        $smsSender->send($message);
    }
}