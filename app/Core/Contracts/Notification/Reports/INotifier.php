<?php

namespace App\Core\Contracts\Notification\Reports;

use App\Models\User;
use App\Models\Report;

interface INotifier {
    /**
     * Notifies the user about a certain event
     * @var User $user
     * @return bool
     */
    public function notify(User $user, Report $report) : bool;
}