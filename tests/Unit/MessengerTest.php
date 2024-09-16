<?php

namespace App\Tests\Unit;

use App\Model\Message;
use App\Service\Messenger;
use App\Service\SenderInterface;
use PHPUnit\Framework\TestCase;

class MessengerTest extends TestCase
{
    public function testSendMessageToSupportedSender(): void
    {
        $emailSenderMock = $this->createMock(SenderInterface::class);
        $smsSenderMock = $this->createMock(SenderInterface::class);

        $message = new Message();
        $message->setType(Message::TYPE_EMAIL);

        $emailSenderMock->expects($this->exactly(2))
            ->method('supports')
            ->with($message)
            ->willReturn(true);

        $emailSenderMock->expects($this->once())
            ->method('send')
            ->with($message);

        $smsSenderMock->expects($this->once())
            ->method('supports')
            ->with($message)
            ->willReturn(false);

        $messenger = new Messenger([$emailSenderMock, $smsSenderMock]);

        $this->assertTrue($emailSenderMock->supports($message));
        $messenger->send($message);
    }
    public function testDoesNotSendMessageWhenNotSupported(): void
    {
        $emailSenderMock = $this->createMock(SenderInterface::class);
        $smsSenderMock = $this->createMock(SenderInterface::class);

        $message = new Message();
        $message->setType(Message::TYPE_SMS);

        $emailSenderMock->expects($this->once())
            ->method('supports')
            ->with($message)
            ->willReturn(false);

        $emailSenderMock->expects($this->never())
            ->method('send');

        $smsSenderMock->expects($this->once())
            ->method('supports')
            ->with($message)
            ->willReturn(false);

        $smsSenderMock->expects($this->never())
            ->method('send');

        $messenger = new Messenger([$emailSenderMock, $smsSenderMock]);
        $messenger->send($message);
    }
}