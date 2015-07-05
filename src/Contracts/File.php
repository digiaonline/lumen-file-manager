<?php namespace Nord\Lumen\FileManager\Contracts;

use Carbon\Carbon;

interface File
{

    const DISK_LOCAL = 'local';
    const DISK_S3    = 's3';


    /**
     * @return string
     */
    public function getId();


    /**
     * @return string
     */
    public function getName();


    /**
     * @return string
     */
    public function getMimeType();


    /**
     * @return int
     */
    public function getByteSize();


    /**
     * @return array
     */
    public function getData();


    /**
     * @return string
     */
    public function getDisk();


    /**
     * @return Carbon
     */
    public function getSavedAt();


    /**
     * @return string
     */
    public function getFilename();


    /**
     * @return string
     */
    public function getFilePath();


    /**
     * @param string $id
     */
    public function setId($id);


    /**
     * @param string $name
     */
    public function setName($name);


    /**
     * @param string $extension
     */
    public function setExtension($extension);


    /**
     * @param string $path
     */
    public function setPath($path);


    /**
     * @param string $mimeType
     */
    public function setMimeType($mimeType);


    /**
     * @param int $byteSize
     */
    public function setByteSize($byteSize);


    /**
     * @param array $data
     */
    public function setData(array $data);


    /**
     * @param string $storage
     */
    public function setDisk($storage);


    /**
     * @param Carbon $savedAt
     */
    public function setSavedAt(Carbon $savedAt);
}
