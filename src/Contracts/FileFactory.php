<?php namespace Nord\Lumen\FileManager\Contracts;

use Carbon\Carbon;

interface FileFactory
{

    /**
     * @param string $id
     * @param string $name
     * @param string $extension
     * @param string $path
     * @param string $mimeType
     * @param int    $byteSize
     * @param array  $data
     * @param string $disk
     * @param Carbon $savedAt
     *
     * @return File
     */
    public function createFile($id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk, Carbon $savedAt);
}
