<?php

namespace App\Providers;

use App\Models\Priority;
use App\Models\Status;
use App\Models\Workspace;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
        Sanctum::ignoreMigrations();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        try {
            DB::connection()->getPdo();
            // The table exists in the database
            $statuses = Status::all();
            $priorities = Priority::all();
            // $user_workspace = auth()->user()->workspaces;
            $workspaces = Workspace::all();

            // dd($workspaces);

            $data = [   'statuses' => $statuses,
                        'priorities' => $priorities,
                        'workspaces' => $workspaces,
                    ];

            view()->share($data);
        } catch (\Exception $e) {
        }

    }
}
