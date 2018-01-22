<?php namespace Nord\Lumen\FileManager\Adapters;

use Cloudinary;
use Nord\Lumen\FileManager\Contracts\File;
use Nord\Lumen\FileManager\Exceptions\AdapterException;

class CloudinaryAdapter extends DiskAdapter
{

    /**
     * CloudinaryAdapter constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->configureClient($config);
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'cloudinary';
    }


    /**
     * @inheritdoc
     */
    public function saveFile($path, $contents, array $options)
    {
        // Cloudinary paths must be given without the extension, therefore we remove it here
        return parent::saveFile(substr($path, 0, (strrpos($path, '.'))), $contents, $options);
    }


    /**
     * @inheritdoc
     */
    public function getFileUrl(File $file, array $options)
    {
        return cloudinary_url($this->createFilePath($file), $options);
    }


    /**
     * @param array $config
     */
    private function configureClient(array $config)
    {
        $cloudName = array_get($config, 'cloudName', env('CLOUDINARY_NAME'));
        $apiKey    = array_get($config, 'apiKey', env('CLOUDINARY_KEY'));
        $apiSecret = array_get($config, 'apiSecret', env('CLOUDINARY_SECRET'));

        Cloudinary::config([
            'cloud_name' => $cloudName,
            'api_key'    => $apiKey,
            'api_secret' => $apiSecret,
        ]);
    }

    /**
     * @inheritdoc
     */
    public function getPresignedUrl(File $file, array $options)
    {
        throw new AdapterException('Presigned URL not supported.');
    }
}
