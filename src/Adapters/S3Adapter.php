<?php namespace Nord\Lumen\FileManager\Adapters;

use Aws\S3\S3Client;
use Nord\Lumen\FileManager\Contracts\File;

class S3Adapter extends DiskAdapter
{

    /**
     * @var S3Client
     */
    private $client;

    /**
     * @var string
     */
    private $bucket;


    /**
     * S3Adapter constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        $this->client = $this->createClient($config);
        $this->bucket = array_get($config, 'bucket', env('S3_BUCKET'));
    }


    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 's3';
    }


    /**
     * @inheritdoc
     */
    public function getFilePath(File $file, array $options)
    {
        return $this->createFilePath($file);
    }


    /**
     * @inheritdoc
     */
    public function getFileUrl(File $file, array $options)
    {
        return $this->client->getObjectUrl($this->bucket, $this->createFilePath($file));
    }


    /**
     * @param array $config
     *
     * @return S3Client
     */
    private function createClient(array $config)
    {
        $key     = array_get($config, 'key', env('S3_KEY'));
        $secret  = array_get($config, 'secret', env('S3_SECRET'));
        $region  = array_get($config, 'region', env('S3_REGION'));
        $version = array_get($config, 'version', 'latest');

        return S3Client::factory([
            'credentials' => ['key' => $key, 'secret' => $secret],
            'region'      => $region,
            'version'     => $version,
        ]);
    }
}
