<?php namespace Nord\Lumen\FileManager;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
use Nord\Lumen\FileManager\Contracts\FileFactory;
use Nord\Lumen\FileManager\Contracts\IdGenerator;
use Nord\Lumen\FileManager\Contracts\DiskAdapter;
use Nord\Lumen\FileManager\Contracts\File as FileContract;
use Nord\Lumen\FileManager\Contracts\FileManager as FileManagerContract;
use Nord\Lumen\FileManager\Contracts\FileStorage;
use Nord\Lumen\FileManager\Exceptions\AdapterException;
use Nord\Lumen\FileManager\Exceptions\StorageException;
use Symfony\Component\HttpFoundation\File\File as FileInfo;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileManager implements FileManagerContract
{

    /**
     * @var FilesystemFactory
     */
    private $filesystem;

    /**
     * @var FileFactory
     */
    private $factory;

    /**
     * @var FileStorage
     */
    private $storage;

    /**
     * @var IdGenerator
     */
    private $idGenerator;

    /**
     * @var DiskAdapter[]
     */
    private $adapters = [];


    /**
     * FileManager constructor.
     *
     * @param FilesystemFactory $filesystem
     * @param FileFactory       $factory
     * @param FileStorage       $storage
     */
    public function __construct(FilesystemFactory $filesystem, FileFactory $factory, FileStorage $storage)
    {
        $this->filesystem = $filesystem;
        $this->factory    = $factory;
        $this->storage    = $storage;
    }


    /**
     * @inheritdoc
     */
    public function saveFile(FileInfo $info, array $options = [])
    {
        if (!isset($options['name'])) {
            $filename        = $this->getFilenameFromFileInfo($info);
            $options['name'] = substr($filename, 0, (strrpos($filename, '.')));
        }

        $file = $this->factory->createFile(
            $this->generateId(),
            $this->normalizeName(array_pull($options, 'name')),
            $this->getExtensionFromFileInfo($info),
            array_pull($options, 'path'),
            $info->getMimeType(),
            $info->getSize(),
            $this->extractDataFromFileInfo($info),
            array_pull($options, 'disk', FileContract::DISK_LOCAL),
            Carbon::now()
        );

        $disk     = $file->getDisk();
        $savePath = $file->getFilePath();

        $resource    = fopen($info->getRealPath(), 'r+');
        $savedToDisk = $this->getAdapter($disk)->saveFile($savePath, $resource, $options);
        if (is_resource($resource)) {
            fclose($resource);
        }
        if (!$savedToDisk) {
            throw new AdapterException("Failed to save file on disk.");
        }

        if (!$this->storage->saveFile($file)) {
            throw new StorageException("Failed to insert file into database.");
        }

        return $file;
    }


    /**
     * @inheritdoc
     */
    public function getFile($id)
    {
        return $this->storage->getFile($id);
    }


    /**
     * @inheritdoc
     */
    public function getFilePath(FileContract $file, array $options = [])
    {
        return $this->getAdapter($file->getDisk())->getFilePath($file, $options);
    }


    /**
     * @inheritdoc
     */
    public function getFileUrl(FileContract $file, array $options = [])
    {
        return $this->getAdapter($file->getDisk())->getFileUrl($file, $options);
    }


    /**
     * @inheritdoc
     */
    public function deleteFile(FileContract $file, array $options = [])
    {
        if (!$this->getAdapter($file->getDisk())->deleteFile($file, $options)) {
            throw new AdapterException("Failed to remove file from disk.");
        }

        if (!$this->storage->deleteFile($file->getId())) {
            throw new StorageException("Failed to delete file from database.");
        }
    }


    /**
     * @param DiskAdapter $adapter
     */
    public function addAdapter(DiskAdapter $adapter)
    {
        $name = $adapter->getName();

        $adapter->setFilesystem($this->filesystem->disk($name));

        $this->adapters[$name] = $adapter;
    }


    /**
     * @param IdGenerator $idGenerator
     */
    public function setIdGenerator(IdGenerator $idGenerator)
    {
        $this->idGenerator = $idGenerator;
    }


    /**
     * @param string $name
     *
     * @return DiskAdapter
     * @throws AdapterException
     */
    protected function getAdapter($name)
    {
        if (!isset($this->adapters[$name])) {
            throw new AdapterException("Adapter for filesystem '$name' not found.");
        }

        return $this->adapters[$name];
    }


    /**
     * @return mixed
     */
    protected function generateId()
    {
        while (!isset($id) || $this->storage->idExists($id)) {
            $id = $this->idGenerator->generate();
        }

        return $id;
    }


    /**
     * @param string $name
     *
     * @return string
     */
    protected function normalizeName($name)
    {
        return $name !== null ? str_slug($name) : null;
    }


    /**
     * @param FileInfo $info
     *
     * @return null|string
     */
    protected function getFilenameFromFileInfo(FileInfo $info)
    {
        return $info instanceof UploadedFile ? $info->getClientOriginalName() : $info->getFilename();
    }


    /**
     * @param FileInfo $info
     *
     * @return string
     */
    protected function getExtensionFromFileInfo(FileInfo $info)
    {
        return $info instanceof UploadedFile ? $info->getClientOriginalExtension() : $info->getExtension();
    }


    /**
     * @param FileInfo $info
     *
     * @return array
     */
    protected function extractDataFromFileInfo(FileInfo $info)
    {
        $data = [];

        if ($info instanceof UploadedFile) {
            $data['original_name']      = $info->getClientOriginalName();
            $data['original_extension'] = $info->getClientOriginalExtension();
        }

        return $data;
    }
}
