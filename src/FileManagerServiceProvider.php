<?php namespace Nord\Lumen\FileManager;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Nord\Lumen\FileManager\Adapters\CloudinaryAdapter;
use Nord\Lumen\FileManager\Adapters\LocalAdapter;
use Nord\Lumen\FileManager\Adapters\S3Adapter;
use Nord\Lumen\FileManager\Contracts\IdGenerator as FileIdGeneratorContract;
use Nord\Lumen\FileManager\Contracts\FileManager as FileManagerContract;
use Nord\Lumen\FileManager\Contracts\FileFactory as FileFactoryContract;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContract;
use Nord\Lumen\FileManager\Facades\FileManager as FileManagerFacade;

class FileManagerServiceProvider extends ServiceProvider
{

    private static $defaultAdapters = [
        ['class' => LocalAdapter::class],
    ];


    /**
     * @inheritdoc
     */
    public function register()
    {
        $this->registerContainerBindings($this->app, $this->app['config']);
        $this->registerFacades();
    }


    /**
     * @param Container        $container
     * @param ConfigRepository $config
     */
    protected function registerContainerBindings(Container $container, ConfigRepository $config)
    {
        $container->alias(FileManager::class, FileManagerContract::class);

        $container->singleton(FileManagerContract::class, function () use ($container, $config) {
            return $this->createManager($container, $config);
        });
    }


    /**
     * Registers facades.
     */
    protected function registerFacades()
    {
        if (!class_exists('FileManager')) {
            class_alias(FileManagerFacade::class, 'FileManager');
        }
    }


    /**
     * @param Container        $container
     * @param ConfigRepository $config
     *
     * @return FileManager
     */
    protected function createManager(Container $container, ConfigRepository $config)
    {
        $filesystem = $container->make('filesystem');
        $factory    = $container->make(FileFactoryContract::class);
        $storage    = $container->make(FileStorageContract::class);

        $fileManager = new FileManager($filesystem, $factory, $storage);

        $this->configureManager($fileManager, $container, $config->get('filemanager', []));

        return $fileManager;
    }


    /**
     * @param FileManager $fileManager
     * @param Container   $container
     * @param array       $config
     */
    protected function configureManager(FileManager $fileManager, Container $container, array $config)
    {
        $idGenerator = $this->createIdGenerator($container, array_get($config, 'idGenerator', []));

        $fileManager->setIdGenerator($idGenerator);

        $adapterConfigs = array_merge(self::$defaultAdapters, array_get($config, 'adapters', []));

        foreach ($adapterConfigs as $adapterConfig) {
            $className = array_pull($adapterConfig, 'class');

            $adapter = $container->make($className, ['config' => $adapterConfig]);

            $fileManager->addAdapter($adapter);
        }
    }


    /**
     * @param Container $container
     * @param array     $config
     *
     * @return FileIdGeneratorContract
     */
    protected function createIdGenerator(Container $container, array $config)
    {
        $className = array_pull($config, 'class', IdGenerator::class);

        return $container->make($className);
    }
}
