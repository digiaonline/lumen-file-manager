<?php namespace Nord\Lumen\FileManager\Doctrine\ORM;

use Doctrine\ORM\EntityManagerInterface;
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

        $entityManager = $container->make(EntityManagerInterface::class);

        $container->singleton(FileStorageContract::class, function () use ($entityManager) {
            return new FileStorage($entityManager);
        });
    }
}
