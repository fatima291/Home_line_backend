<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;
use Kreait\Firebase\Messaging\MulticastSendReport;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(base_path('firebase-credentials.json'));

        $this->messaging = $factory->createMessaging();
    }

    public function sendToTokens(array $tokens, string $title, string $body): ?MulticastSendReport
    {
        if (empty($tokens)) {
            return null;
        }

        $message = CloudMessage::new()
            ->withNotification(Notification::create($title, $body));

        return $this->messaging->sendMulticast($message, $tokens);
    }
}