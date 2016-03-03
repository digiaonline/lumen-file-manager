<?php

namespace Nord\Lumen\FileManager\Eloquent;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Nord\Lumen\FileManager\Contracts\FileFactory as FileFactoryContract;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContract;

class EloquentServiceProvider extends ServiceProvider
{

    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerContainerBindings($this->app);
    }


    /**
     * @param Container $container
     */
    protected function registerContainerBindings(Container $container)
    {
        $container->singleton(FileFactoryContract::class, function () {
            return new FileFactory(File::class);
        });
        
        $container->singleton(FileStorageContract::class, function () {
            return new FileStorage();
        });
    }
}
