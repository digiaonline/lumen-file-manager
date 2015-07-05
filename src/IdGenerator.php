<?php namespace Nord\Lumen\FileManager;

use Crisu83\ShortId\ShortId;
use Nord\Lumen\FileManager\Contracts\IdGenerator as IdGeneratorContract;

class IdGenerator implements IdGeneratorContract
{

    /**
     * @var ShortId
     */
    private $generator;


    /**
     * IdGenerator constructor.
     */
    public function __construct()
    {
        $this->generator = new ShortId;
    }


    /**
     * @inheritdoc
     */
    public function generate()
    {
        return $this->generator->generate();
    }
}
