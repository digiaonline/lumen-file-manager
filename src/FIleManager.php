<?php namespace Nord\Lumen\FileManager;

use Carbon\Carbon;
use Illuminate\Contracts\Filesystem\Factory as FilesystemFactory;
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
     * @param FilesystemFactory $factory
     * @param FileStorage       $storage
     */
    public function __construct(FilesystemFactory $factory, FileStorage $storage)
    {
        $this->factory = $factory;
        $this->storage = $storage;
    }


    /**
     * @inheritdoc
     */
    public function saveFile(FileInfo $info, $name, array $options = [])
    {
        /** @var FileContract $file */
        $file = app()->make(FileContract::class);

        $file->setId($this->generateId());
        $file->setName($this->normalizeName($name));
        $file->setExtension($this->getExtensionFromFileInfo($info));
        $file->setPath(array_pull($options, 'path'));
        $file->setMimeType($info->getMimeType());
        $file->setByteSize($info->getSize());
        $file->setData($this->extractDataFromFileInfo($info));
        $file->setDisk(array_pull($options, 'disk', FileContract::DISK_LOCAL));
        $file->setSavedAt(Carbon::now());

        $disk     = $file->getDisk();
        $savePath = $file->getFilePath();

        if (!$this->getAdapter($disk)->saveFile($savePath, file_get_contents($info->getRealPath()), $options)) {
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

        $adapter->setFilesystem($this->factory->disk($name));

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
        return str_slug($name);
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
