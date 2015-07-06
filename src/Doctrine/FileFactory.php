<?php namespace Nord\Lumen\FileManager\Doctrine;

use Nord\Lumen\FileManager\Contracts\FileFactory as FileFactoryContract;
use Nord\Lumen\FileManager\Contracts\FileManager;

class FileFactory implements FileFactoryContract
{

    /**
     * @inheritdoc
     */
    public function createFile(FileManager $manager, $id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk)
    {
        return new File($manager, $id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk);
    }
}
