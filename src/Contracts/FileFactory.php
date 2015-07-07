<?php namespace Nord\Lumen\FileManager\Contracts;

interface FileFactory
{

    /**
     * @param string      $id
     * @param string      $name
     * @param string      $extension
     * @param string      $path
     * @param string      $mimeType
     * @param int         $byteSize
     * @param array       $data
     * @param string      $disk
     *
     * @return File
     */
    public function createFile($id, $name, $extension, $path, $mimeType, $byteSize, $data, $disk);
}
