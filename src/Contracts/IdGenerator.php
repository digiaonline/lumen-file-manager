<?php namespace Nord\Lumen\FileManager\Contracts;

interface IdGenerator
{

    /**
     * @return mixed
     */
    public function generate();
}
