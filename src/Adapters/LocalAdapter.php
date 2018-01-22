<?php namespace Nord\Lumen\FileManager\Adapters;

use Nord\Lumen\FileManager\Contracts\File;

class LocalAdapter extends DiskAdapter
{

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'local';
    }


    /**
     * @inheritdoc
     */
    public function getFilePath(File $file, array $options)
    {
        return (isset($options['path']) ? $options['path'] : '') . $this->createFilePath($file);
    }


    /**
     * @inheritdoc
     */
    public function getFileUrl(File $file, array $options)
    {
        return url($this->createFilePath($file));
    }

    /**
     * @inheritdoc
     */
    public function getPresignedUrl(File $file, array $options)
    {
        // Use the normal URL here, as we don't want to break anything.
        return url($this->createFilePath($file));
    }
}
