<?php namespace Nord\Lumen\FileManager\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Nord\Lumen\FileManager\Contracts\File as FileContract;
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
     *
     */
    protected function registerContainerBindings(Container $container)
    {
        $entityManager = $container->make(EntityManagerInterface::class);

        $container->singleton(FileStorageContract::class, function () use ($entityManager) {
            return new FileStorage($entityManager);
        });

        $container->bind(FileContract::class, function () {
            return new File();
        });
    }
}
