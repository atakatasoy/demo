<?php

namespace App\Core\Notification\Reports\Notifiers;

use App\Core\Contracts\Notification\Reports\INotifier;
use App\Models\User;
use App\Models\Report;

class EmailNotifier implements INotifier {
    /**
     * Notifies user
     * @param User $user
     * @param Report $report
     */
    public function notify(User $user, Report $report)
    {
        //Send email using laravel services
    }
}