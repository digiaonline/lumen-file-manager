<?php

namespace Nord\Lumen\FileManager\Eloquent;

use Carbon\Carbon;
use Nord\Lumen\FileManager\Contracts\FileFactory as FileFactoryContract;

class FileFactory implements FileFactoryContract
{

    /**
     * @inheritdoc
     */
    protected $fileClass;


    /**
     * FileFactory constructor
     *
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

        return new $class([
            'file_id' => $id,
            'name'      => $name,
            'extension' => $extension,
            'path'      => $path,
            'mime_type' => $mimeType,
            'byte_size' => $byteSize,
            'data'      => $data,
            'disk'      => $disk,
            'saved_at'  => $savedAt,
        ]);
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
