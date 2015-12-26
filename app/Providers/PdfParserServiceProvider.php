<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PdfParserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
      $this->loadViewsFrom(__DIR__.'/views', 'pdfParser');

     $this->publishes([
          __DIR__.'/views' => base_path('resources/views/smalot/pdfParser'),
      ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
