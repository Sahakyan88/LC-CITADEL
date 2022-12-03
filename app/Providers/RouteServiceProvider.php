<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use App;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Http\Request;


class RouteServiceProvider extends ServiceProvider
{
      /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/dashboard';
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->configureRateLimiting();

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        // $this->mapApiRoutes();

        $this->mapAdminRoutes();
        
        $this->mapWebRoutes();

    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        // Localization
        $request = app(\Illuminate\Http\Request::class);
        $locale = $request->segment(1);

        $activeLangs = array('am','en','ru');
        
        if ( ! in_array($locale, $activeLangs)) {
            App::setLocale(config('app.fallback_locale'));
        } else {
            App::setLocale($locale);
        }
        // Localization
        
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace.'\Admin')
             ->group(base_path('routes/api.php'));
    }

     /**
     * Define the "admin" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        Route::prefix('admin')
             ->middleware('admin')
             ->namespace('App\Http\Controllers\Admin')
             ->group(base_path('routes/admin.php'));
    }
    
    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
