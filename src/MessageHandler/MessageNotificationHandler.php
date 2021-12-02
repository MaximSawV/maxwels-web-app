<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 12/2/21
 * Time: 10:13 AM
 */

// src/MessageHandler/MessageNotificationHandler.php
namespace App\MessageHandler;

use App\Message\MessageNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

class SmsNotificationHandler implements MessageHandlerInterface
{
    public function __invoke(MessageNotification $message)
    {
        // ... do some work - like sending an SMS message!
    }
}