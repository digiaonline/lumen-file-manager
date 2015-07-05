<?php namespace Nord\Lumen\FileManager\Contracts;

interface FileStorage
{

    /**
     * @param File $file
     *
     * @return bool
     */
    public function saveFile(File $file);


    /**
     * @param string $id
     *
     * @return File
     */
    public function getFile($id);


    /**
     * @param string $id
     *
     * @return bool
     */
    public function deleteFile($id);


    /**
     * @param string $id
     *
     * @return bool
     */
    public function idExists($id);
}
