<?php

declare(strict_types = 1);

namespace App\Core\Notification\Reports;

use App\Core\Contracts\Notification\Reports\INotifier;
use App\Core\Exceptions\InvalidFactoryArgumentException;

/**
 * This class is responsible of creating INotifier objects at run-time
 */
class NotifierFactory {
    /**
     * @var array
     */
    private $typeBindings = [
        'sms' => \App\Core\Notification\Reports\Notifiers\SmsNotifier::class,
        'email' => \App\Core\Notification\Reports\Notifiers\EmailNotifier::class,
        'push' => \App\Core\Notification\Reports\Notifiers\PushNotifier::class
    ];

    /**
     * @var array
     */
    private $notifiers = [];

    public function make(?string $type = null) : INotifier
    {
        $type = strtolower($type ?? 'sMs');
        if(!isset($this->typeBindings[$type])){
            throw new InvalidFactoryArgumentException();
        }

        if(isset($this->notifiers[$type])){
            return $this->notifiers[$type];
        }

        return $this->notifiers[$type] = new $this->typeBindings[$type]();
    }
}