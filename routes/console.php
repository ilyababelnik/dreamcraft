<?php

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::call(function () {
    $expiredUsers = User::whereNotNull('plan_id')
        ->where('duration_plan', '<', Carbon::now())
        ->get();

    $expiredUsers->each(function ($user) {
        $user->update([
            'plan_id' => null,
            'start_plan' => null,
            'duration_plan' => null,
            'category_id' => null,
        ]);
    });
})->daily();
