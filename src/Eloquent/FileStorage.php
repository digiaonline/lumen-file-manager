<?php

namespace Nord\Lumen\FileManager\Eloquent;

use Illuminate\Support\Facades\Log;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContract;
use Nord\Lumen\FileManager\Contracts\File as FileContract;

class FileStorage implements FileStorageContract
{

    /**
     * @param File $file
     */
    public function saveFile(FileContract $file)
    {
        Log::debug(var_export($file->attributesToArray(), true));
        return $file->save();
    }


    /**
     * @inheritdoc
     */
    public function getFile($id)
    {
        return File::findByFileId($id);
    }


    /**
     * @inheritdoc
     */
    public function deleteFile($id)
    {
        $file = $this->getFile($id);

        if ($file === null) {
            return false;
        }

        $file->delete();

        return true;
    }


    /**
     * @inheritdoc
     */
    public function idExists($id)
    {
        return $this->getFile($id) !== null;
    }
}