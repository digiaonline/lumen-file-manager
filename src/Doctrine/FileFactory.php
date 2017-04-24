<?php namespace Nord\Lumen\FileManager\Doctrine;

use Carbon\Carbon;
use Nord\Lumen\FileManager\Contracts\FileFactory as FileFactoryContract;

class FileFactory implements FileFactoryContract
{

    /**
     * @var string Full namespace of class to use when creating files
     */
    protected $fileClass;

    /**
     * FileFactory constructor
     * @param string $fileClass
     */
    public function __construct($fileClass)
    {
        $this->setFileClass($fileClass);
    }

    /**
     * @inheritdoc
     */
    public function createFile($id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk, Carbon $savedAt)
    {
        $class = $this->getFileClass();
        return new $class($id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk, $savedAt);
    }

    /**
     * @return string
     */
    protected function getFileClass()
    {
        return $this->fileClass;
    }

    /**
     * @param string $fileClass
     */
    protected function setFileClass($fileClass)
    {
        $this->fileClass = $fileClass;
    }
}
