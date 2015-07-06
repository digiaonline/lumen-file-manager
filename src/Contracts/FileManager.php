<?php namespace Nord\Lumen\FileManager\Contracts;

use Nord\Lumen\FileManager\Exceptions\AdapterException;
use Nord\Lumen\FileManager\Exceptions\StorageException;
use Symfony\Component\HttpFoundation\File\File as FileInfo;

interface FileManager
{

    /**
     * @param FileInfo $info
     * @param array    $options
     *
     * @return File
     * @throws AdapterException
     * @throws StorageException
     */
    public function saveFile(FileInfo $info, array $options = []);


    /**
     * @param string $id
     *
     * @return File
     */
    public function getFile($id);

    /**
     * @param File  $file
     * @param array $options
     *
     * @return string
     */
    public function getFilePath(File $file, array $options = []);


    /**
     * @param File  $file
     * @param array $options
     *
     * @return string
     */
    public function getFileUrl(File $file, array $options = []);


    /**
     * @param File $file
     *
     * @throws AdapterException
     * @throws StorageException
     */
    public function deleteFile(File $file);
}
