<?php namespace Nord\Lumen\FileManager\Doctrine;

use Carbon\Carbon;
use Nord\Lumen\Doctrine\Traits\AutoIncrements;
use Nord\Lumen\FileManager\Contracts\File as FileContract;
use Nord\Lumen\FileManager\Contracts\FileManager;

class File implements FileContract
{

    use AutoIncrements;

    /**
     * @var FileManager
     */
    private $manager;

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $extension;

    /**
     * @var string
     */
    private $path;

    /**
     * @var string
     */
    private $mimeType;

    /**
     * @var int
     */
    private $byteSize;

    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $disk;

    /**
     * @var Carbon
     */
    private $savedAt;


    /**
     * File constructor.
     *
     * @param FileManager $manager
     * @param string      $id
     * @param string      $name
     * @param string      $extension
     * @param string      $path
     * @param string      $mimeType
     * @param int         $byteSize
     * @param array       $data
     * @param string      $disk
     */
    public function __construct(
        FileManager $manager,
        $id,
        $name,
        $extension,
        $path,
        $mimeType,
        $byteSize,
        array $data,
        $disk
    ) {
        $this->setManager($manager);
        $this->setId($id);
        $this->setName($name);
        $this->setExtension($extension);
        $this->setPath($path);
        $this->setMimeType($mimeType);
        $this->setByteSize($byteSize);
        $this->setData($data);
        $this->setDisk($disk);
        $this->setSavedAt(Carbon::now());
    }


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }


    /**
     * @return int
     */
    public function getByteSize()
    {
        return $this->byteSize;
    }


    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }


    /**
     * @return string
     */
    public function getDisk()
    {
        return $this->disk;
    }


    /**
     * @return Carbon
     */
    public function getSavedAt()
    {
        return $this->savedAt;
    }


    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->name . '-' . $this->id . '.' . $this->extension;
    }


    /**
     * @inheritdoc
     */
    public function getFilePath()
    {
        return $this->getPath() . $this->getFilename();
    }


    /**
     * @inheritdoc
     */
    public function getUrl(array $options = [])
    {
        return $this->manager->getFileUrl($this, $options);
    }


    /**
     * @param FileManager $manager
     */
    private function setManager(FileManager $manager)
    {
        $this->manager = $manager;
    }


    /**
     * @param string $id
     *
     * @throws \Exception
     */
    private function setId($id)
    {
        if (empty($id)) {
            throw new \Exception('File ID cannot be empty.');
        }

        $this->id = $id;
    }


    /**
     * @param string $name
     *
     * @throws \Exception
     */
    private function setName($name)
    {
        if (empty($name)) {
            throw new \Exception('File name cannot be empty.');
        }

        $this->name = $name;
    }


    /**
     * @param string $extension
     *
     * @throws \Exception
     */
    private function setExtension($extension)
    {
        if (empty($extension)) {
            throw new \Exception('File extension cannot be empty.');
        }

        $this->extension = $extension;
    }


    /**
     * @param string $path
     */
    private function setPath($path)
    {
        $this->path = $path;
    }


    /**
     * @param string $mimeType
     */
    private function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }


    /**
     * @param int $byteSize
     */
    private function setByteSize($byteSize)
    {
        $this->byteSize = $byteSize;
    }


    /**
     * @param array $data
     */
    private function setData(array $data)
    {
        $this->data = $data;
    }


    /**
     * @param string $storage
     */
    private function setDisk($storage)
    {
        $this->disk = $storage;
    }


    /**
     * @param Carbon $savedAt
     */
    private function setSavedAt(Carbon $savedAt)
    {
        $this->savedAt = $savedAt;
    }


    /**
     * @return string
     */
    private function getPath()
    {
        return isset($this->path) ? $this->path . '/' : '';
    }
}
