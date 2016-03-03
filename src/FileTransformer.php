<?php

namespace Nord\Lumen\FileManager;

use League\Fractal\TransformerAbstract;
use Nord\Lumen\FileManager\Contracts\File as FileContract;

class FileTransformer extends TransformerAbstract
{

    /**
     * @param FileContract $file
     *
     * @return array
     */
    public function transform(FileContract $file)
    {
        return [
            'id'        => $file->getId(),
            'name'      => $file->getName(),
            'mime_type' => $file->getMimeType(),
            'byte_size' => $file->getByteSize(),
            'data'      => $file->getData(),
            'saved_at'  => $file->getSavedAt(),
        ];
    }
}
