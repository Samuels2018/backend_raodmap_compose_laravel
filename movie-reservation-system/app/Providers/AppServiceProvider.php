<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\ReservationPolicy;

class AppServiceProvider extends ServiceProvider {
  protected $policies = [
    Reservation::class => ReservationPolicy::class,
  ];

  /**
   * Register any application services.
   */
  public function register(): void
  {
      //
  }

  /**
   * Bootstrap any application services.
   */
  public function boot(): void
  {
      //
  }
}
