<?php namespace Nord\Lumen\FileManager\Facades;

use Illuminate\Support\Facades\Facade;

class FileManager extends Facade
{

    /**
     * @inheritdoc
     */
    protected static function getFacadeAccessor()
    {
        return 'Nord\Lumen\FileManager\Contracts\FileManager';
    }
}
