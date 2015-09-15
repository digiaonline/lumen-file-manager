<?php namespace Nord\Lumen\FileManager\Doctrine\ODM;

use Doctrine\ODM\DocumentManagerInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Nord\Lumen\FileManager\Contracts\FileFactory as FileFactoryContract;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContract;

class DoctrineServiceProvider extends ServiceProvider
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
            return new FileFactory();
        });

        $documentManager = $container->make(DocumentManagerInterface::class);

        $container->singleton(FileStorageContract::class, function () use ($documentManager) {
            return new FileStorage($documentManager);
        });
    }
}
