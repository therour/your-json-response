<?php

namespace Therour\YourJsonResponse;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Response;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfiguration();

        $this->bootMacroResponses();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot the macroing responses here.
     *
     * @return void
     */
    protected function bootMacroResponses()
    {
        $skeletons = config('yjresponse.skeleton');
        $defaults = config('yjresponse.defaults');

        foreach ($skeletons as $name => $skeleton) {
            Response::macro($name, function ($data, $message = null, $code = null) use ($name, $defaults) {
                if (is_null($message)) {
                    return new YJResponse($data, $defaults[$name]['message'], $defaults[$name]['code']);
                }
                if (is_null($code)) {
                    return new YJResponse($data, $message, $defaults[$name]['code']);
                }

                return new YJResponse($data, $message, $code, $name);
            });
        }
    }

    /**
     * Register the configuration used in package.
     *
     * @return void
     */
    protected function registerConfiguration()
    {
        $this->mergeConfigFrom(
            $this->packagePath('config/yjresponse.php'), 'yjresponse'
        );
        $this->publishes(
            [$this->packagePath('config/yjresponse.php') => config_path('yjresponse.php')],
            'config'
        );
    }

    /**
     * Loads a path relative to the package base directory
     *
     * @param  string $path
     * @return string
     */
    protected function packagePath($path = '')
    {
        return sprintf("%s/../%s", __DIR__, $path);
    }
}

