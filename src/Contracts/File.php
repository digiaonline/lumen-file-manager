<?php namespace Nord\Lumen\FileManager\Contracts;

use Carbon\Carbon;

interface File
{
    const DISK_LOCAL      = 'local';
    const DISK_S3         = 's3';
    const DISK_CLOUDINARY = 'cloudinary';


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
     * @param array $options
     *
     * @return string
     */
    public function getUrl(array $options = []);
}
