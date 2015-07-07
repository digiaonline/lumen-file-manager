<?php namespace Nord\Lumen\FileManager\Doctrine;

use Nord\Lumen\FileManager\Contracts\FileFactory as FileFactoryContract;
use Nord\Lumen\FileManager\Contracts\FileManager;

class FileFactory implements FileFactoryContract
{

    /**
     * @inheritdoc
     */
    public function createFile($id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk)
    {
        return new File($id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk);
    }
}
