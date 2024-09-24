<?php

namespace App\Providers;

use App\Models\GameTable;
use App\Models\Hand;
use App\Models\Jackpot;
use App\Models\JackpotWinner;
use App\Models\Role;
use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Laravel Authentication Events
        'Illuminate\Auth\Events\Login' => [
            'App\Listeners\LogUserLogin',
        ],
        'Illuminate\Auth\Events\Logout' => [
            'App\Listeners\LogUserLogout',
        ],
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
{
    // Register event listeners for multiple models
    $models = [
        User::class,
        GameTable::class,
        Hand::class,
        Jackpot::class,
        JackpotWinner::class,
        Role::class,

    ];

    // Attach event listeners for each model
    foreach ($models as $model) {
        $this->attachEventListeners($model);
    }
}

protected function attachEventListeners($model): void
{
    // Attach the 'created' event listener
    $model::created(function ($modelInstance) use ($model) {
        $this->logEvent($modelInstance, 'created');
    });

    // Attach the 'updated' event listener
    $model::updated(function ($modelInstance) use ($model) {
        $this->logEvent($modelInstance, 'updated');
    });

    // Attach the 'deleted' event listener
    $model::deleted(function ($modelInstance) use ($model) {
        $this->logEvent($modelInstance, 'deleted');
    });
}

    private function logEvent($modelInstance, $action)
    {
        // Avoid recursive event triggering
        AuditLog::withoutEvents(function () use ($modelInstance, $action) {
            AuditLog::create([
                'user_id' => Auth::check() ? Auth::id() : null,  // ID of the user performing the action
                'event_type' => $action,
                'details' => "User {$action} field with ID {$modelInstance->id}",
                'ip_address' => request()->ip(),
            ]);
        });
    }
}
