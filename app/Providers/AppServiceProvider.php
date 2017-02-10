<?php

namespace App\Providers;

use App\View\Composers;
use App\View\ThemeViewFinder;
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
        $this->app['view']->composer('*', Composers\AddBackendUser::class);
        $this->app['view']->composer('*', Composers\AddStatusMessage::class);

        $this->app['view']->composer('layouts.frontend', Composers\AddLoggedInUser::class);
        $this->app['view']->composer('layouts.frontend', Composers\InjectPages::class);

        $this->app['view']->setFinder($this->app['theme.finder']);
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
