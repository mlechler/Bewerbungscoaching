<?php

namespace App\Providers;

use App\Page;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapMemberRoutes();

        $this->mapEmployeeRoutes();

        //
    }

    /**
     * Define the "employee" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapEmployeeRoutes()
    {
        Route::group([
            'middleware' => ['web', 'employee', 'auth:employee'],
            'prefix' => 'employee',
            'as' => 'employee.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/employee.php');
        });
    }

    /**
     * Define the "member" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapMemberRoutes()
    {
        Route::group([
            'middleware' => ['web', 'member', 'auth:member'],
            'prefix' => 'member',
            'as' => 'member.',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/member.php');
        });
    }

    /**
     * Define the "user" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => $this->namespace,
        ], function ($router) {
            require base_path('routes/web.php');
        });

        foreach(Page::all() as $page) {
            Route::get($page->uri, ['as' => $page->name, function() use ($page){
                return $this->app->call('App\Http\Controllers\PageController@show', [
                   'page' => $page,
                    'parameters' => Route::current()->parameters()
                ]);
            }]);
        }
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
        Route::group([
            'middleware' => 'api',
            'namespace' => $this->namespace,
            'prefix' => 'api',
        ], function ($router) {
            require base_path('routes/api.php');
        });
    }
}
