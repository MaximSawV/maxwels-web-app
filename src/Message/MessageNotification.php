<?php
/**
 * Created by PhpStorm.
 * User: maxim
 * Date: 12/2/21
 * Time: 10:11 AM
 */

// src/Message/MessageNotification.php
namespace App\Message;

class MessageNotification
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}