<?php

namespace App\Core\Repositories;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\UserType;
use App\Models\Report;
use App\Models\ReportType;

class UserRepository {
    /**
     * Returns all the customers that wants to be reported about their purchases
     * @return Illuminate\Support\Collection
     */
    public function dailyReportableBuyers()
    {
        $user = new User;
        return $this->getReportableUsers('Buyer', 'Daily')->map(function($item) use($user){
            return $user->newInstance((array)$item, true);
        });
    }

    /**
     * Returns all the owners that wants to be reported about their sales
     * @return Illuminate\Support\Collection
     */
    public function dailyReportableSellers()
    {
        $user = new User;
        return $this->getReportableUsers('Seller', 'Daily')->map(function($item) use($user){
            return $user->newInstance((array)$item, true);
        });
    }

    protected function getReportableUsers($userType, $reportType)
    {
        return DB::table('users')
            ->join('user_types', 'users.user_type_id', '=', 'user_types.id')
            ->join('reports', 'reports.user_id', '=', 'users.id')
            ->join('report_types', 'report_types.id', '=', 'reports.report_type_id')
            ->where('user_types.type', '=', $userType)
            ->where('report_types.type', '=', $reportType)
            ->get(['users.*']);
    }
}