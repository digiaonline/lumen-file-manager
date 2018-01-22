<?php namespace Nord\Lumen\FileManager\Adapters;

use Nord\Lumen\FileManager\Contracts\DiskAdapter as AdapterContract;
use Illuminate\Contracts\Filesystem\Filesystem;
use Nord\Lumen\FileManager\Contracts\File;

abstract class DiskAdapter implements AdapterContract
{
    const DEFAULT_DIRECTORY = 'files';

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var null|string
     */
    private $directory;


    /**
     * @inheritdoc
     */
    abstract public function getName();


    /**
     * @inheritdoc
     */
    abstract public function getFileUrl(File $file, array $options);


    /**
     * @inheritdoc
     */
    abstract public function getPresignedUrl(File $file, array $options);


    /**
     * FilesystemAdapter constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->configure($config);
    }


    /**
     * @inheritdoc
     */
    public function saveFile($path, $contents, array $options)
    {
        return $this->filesystem->put($this->directory . '/' . $path, $contents, $options);
    }


    /**
     * @inheritdoc
     */
    public function fileExists(File $file, array $options)
    {
        return $this->filesystem->exists($this->getFilePath($file, $options));
    }


    /**
     * @inheritdoc
     */
    public function deleteFile(File $file, array $options)
    {
        return $this->filesystem->delete($this->getFilePath($file, $options));
    }


    /**
     * @inheritdoc
     */
    public function getFilePath(File $file, array $options)
    {
        return $this->createFilePath($file);
    }


    /**
     * @inheritdoc
     */
    public function setFilesystem(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }


    /**
     * @param array $config
     */
    protected function configure(array $config)
    {
        $this->directory = array_get($config, 'directory', static::DEFAULT_DIRECTORY);
    }


    /**
     * @param File $file
     *
     * @return string
     */
    protected function createFilePath(File $file)
    {
        return $this->directory . '/' . $file->getFilePath();
    }
}
