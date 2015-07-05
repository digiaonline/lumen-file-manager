<?php namespace Nord\Lumen\FileManager;

use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;
use Nord\Lumen\FileManager\Adapters\CloudinaryAdapter;
use Nord\Lumen\FileManager\Adapters\LocalAdapter;
use Nord\Lumen\FileManager\Adapters\S3Adapter;
use Nord\Lumen\FileManager\Contracts\IdGenerator as FileIdGeneratorContract;
use Nord\Lumen\FileManager\Contracts\FileManager as FileManagerContracts;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContracts;
use Nord\Lumen\FileManager\Facades\FileManager as FileManagerFacade;

class FileManagerServiceProvider extends ServiceProvider
{

    private static $defaultAdapters = [
        ['class' => LocalAdapter::class],
        ['class' => S3Adapter::class],
        ['class' => CloudinaryAdapter::class],
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
        $container->alias(FileManager::class, FileManagerContracts::class);

        $container->singleton(FileManagerContracts::class, function () use ($container, $config) {
            return $this->createManager($container, $config);
        });
    }


    /**
     *
     */
    protected function registerFacades()
    {
        class_alias(FileManagerFacade::class, 'FileManager');
    }


    /**
     * @param Container        $container
     * @param ConfigRepository $config
     */
    protected function createManager(Container $container, ConfigRepository $config)
    {
        $filesystem = $container->make('filesystem');
        $storage    = $container->make(FileStorageContracts::class);

        $fileManager = new FileManager($filesystem, $storage);

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
