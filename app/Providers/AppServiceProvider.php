<?php

namespace App\Providers;

use App\Models\Lembaga;
use App\Support\Pawukon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::defaultView('situs.partials.pager');
        Paginator::defaultSimpleView('situs.partials.pager');

        View::composer('layouts.situs', function ($view) {
            $hari = Pawukon::hariIni();
            $view->with([
                'menuLembaga' => Lembaga::orderBy('urutan')->get(['nama', 'slug']),
                'tanggalBali' => Pawukon::tanggalMasehi(now()->toImmutable()).' · '.Pawukon::tanggalBali().($hari ? ' · Rahajeng '.$hari : ''),
            ]);
        });
    }
}
