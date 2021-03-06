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
     * @inheritdoc
     */
    public function getPresignedUrl(File $file, array $options)
    {
        $expires = isset($options['expires']) ? $options['expires'] : '+5 minutes';

        $cmd = $this->client->getCommand('GetObject', [
            'Bucket' => $this->bucket,
            'Key'    => $this->createFilePath($file),
        ]);

        $request = $this->client->createPresignedRequest($cmd, $expires);

        return (string) $request->getUri();
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

        return new S3Client([
            'credentials' => ['key' => $key, 'secret' => $secret],
            'region'      => $region,
            'version'     => $version,
        ]);
    }
}
