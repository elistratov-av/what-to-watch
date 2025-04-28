<?php

use App\Jobs\FetchLastComments;
use App\Jobs\UpdateFilms;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::job(UpdateFilms::class)->everyFiveMinutes();
Schedule::job(FetchLastComments::class)->everyFiveMinutes();
