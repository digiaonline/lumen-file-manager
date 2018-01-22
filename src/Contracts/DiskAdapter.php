<?php namespace Nord\Lumen\FileManager\Contracts;

use Illuminate\Contracts\Filesystem\Filesystem;
use Nord\Lumen\FileManager\Exceptions\AdapterException;

interface DiskAdapter
{

    /**
     * @return string
     */
    public function getName();


    /**
     * @param string $path
     * @param string|resource $contents
     * @param array  $options
     *
     * @return bool
     */
    public function saveFile($path, $contents, array $options);


    /**
     * @param File  $file
     * @param array $options
     *
     * @return string
     */
    public function getFilePath(File $file, array $options);


    /**
     * @param File  $file
     * @param array $options
     *
     * @return string
     */
    public function getFileUrl(File $file, array $options);


    /**
     * @param File  $file
     * @param array $options Set the `expires` option to change URL expiration time. Defaults to +5 minutes.
     *
     * @return string
     * @throws AdapterException
     */
    public function getPresignedUrl(File $file, array $options);


    /**
     * @param File  $file
     * @param array $options
     *
     * @return bool
     */
    public function fileExists(File $file, array $options);


    /**
     * @param File  $file
     * @param array $options
     *
     * @return bool
     */
    public function deleteFile(File $file, array $options);


    /**
     * @param Filesystem $filesystem
     */
    public function setFilesystem(Filesystem $filesystem);
}
