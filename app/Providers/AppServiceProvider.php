<?php

namespace App\Providers;

use App\View\Composers;
use App\View\ThemeViewFinder;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', Composers\AddBackendUser::class);
        View::composer('*', Composers\AddStatusMessage::class);

        View::composer('*', Composers\AddLoggedInUser::class);
        View::composer('layouts.frontend', Composers\InjectPages::class);

        View::setFinder($this->app['theme.finder']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Hesto\MultiAuth\MultiAuthServiceProvider');
        }

        $this->app->singleton('theme.finder', function ($app) {
            $finder = new ThemeViewFinder($app['files'], $app['config']['view.paths']);

            $config = $app['config']['cms.theme'];

            $original_finder = $this->app['view']->getFinder();

            //We need to get our hints from the base level
            $finder->setHints($original_finder->getHints());

            $finder->setBasePath($app['path.public'] . '/' . $config['folder']);
            $finder->setActiveTheme($config['active']);

            return $finder;
        });
    }
}
