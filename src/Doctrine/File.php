<?php namespace Nord\Lumen\FileManager\Doctrine;

use Carbon\Carbon;
use Nord\Lumen\Doctrine\Traits\AutoIncrements;
use Nord\Lumen\FileManager\Contracts\File as FileContract;

class File implements FileContract
{

    use AutoIncrements;

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
     * @return string
     */
    public function getFilePath()
    {
        return $this->getPath() . $this->getFilename();
    }


    /**
     * @param string $id
     *
     * @throws \Exception
     */
    public function setId($id)
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
    public function setName($name)
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
    public function setExtension($extension)
    {
        if (empty($extension)) {
            throw new \Exception('File extension cannot be empty.');
        }

        $this->extension = $extension;
    }


    /**
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }


    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = $mimeType;
    }


    /**
     * @param int $byteSize
     */
    public function setByteSize($byteSize)
    {
        $this->byteSize = $byteSize;
    }


    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }


    /**
     * @param string $storage
     */
    public function setDisk($storage)
    {
        $this->disk = $storage;
    }


    /**
     * @param Carbon $savedAt
     */
    public function setSavedAt(Carbon $savedAt)
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
