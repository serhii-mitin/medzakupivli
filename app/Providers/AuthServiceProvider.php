<?php

namespace App\Providers;

use App\Models\VaccinationHistory;
use App\Policies\VaccinationHistoryPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        VaccinationHistory::class => VaccinationHistoryPolicy::class,
    ];

    public function boot(): void
    {
    }
}
