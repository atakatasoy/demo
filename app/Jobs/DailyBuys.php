<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Core\Repositories\UserRepository;
use Carbon\Carbon;

class DailyBuys implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserRepository $repo, NotifierFactory $factory)
    {
        $repo->dailyReportableBuyers()->each(function($user) use($factory){
            $buys = $user->buys()
                ->where('product_sold_at', '>', Carbon::today()->addDays(-1)->timestamp)
                ->get();

            $spent = $buys->reduce(function($total, $purchase){
                return $total + ($purchase->price * $purchase->quantity);
            }, 0);

            $report = $user->reports()->where('report_type_id', '=', 1)->first();
            $report->update(['price'=>$spent, 'last_sent_at' => Carbon::now()]);

            switch(true){
                case $user->via_sms:
                    $factory->make('sms')->notify($user, $report);
                case $user->via_email:
                    $factory->make('email')->notify($user, $report);
                case $user->via_push:
                    $factory->make('push')->notify($user, $report);
            }
        });
    }
}
