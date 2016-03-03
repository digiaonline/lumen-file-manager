<?php

namespace Nord\Lumen\FileManager\Eloquent;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Nord\Lumen\FileManager\Contracts\File as FileContract;
use Nord\Lumen\FileManager\Facades\FileManager;

class File extends Model implements FileContract
{

    /**
     * @inheritdoc
     */
    protected $fillable = [
        'file_id',
        'name',
        'extension',
        'path',
        'mime_type',
        'byte_size',
        'data',
        'disk',
        'saved_at',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'data' => 'array',
    ];

    /**
     * @var array
     */
    protected $dates = [
        'saved_at',
    ];

    /**
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * @var bool
     */
    public $timestamps = false;


    /**
     * @return string
     */
    public function getId()
    {
        return $this->attributes['file_id'];
    }


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return string
     */
    public function getExtension()
    {
        return $this->extension;
    }


    /**
     * @return string
     */
    public function getMimeType()
    {
        return $this->attributes['mime_type'];
    }


    /**
     * @return int
     */
    public function getByteSize()
    {
        return $this->attributes['byte_size'];
    }


    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }


    /**
     * @return string
     */
    public function getDisk()
    {
        return $this->disk;
    }


    /**
     * @return Carbon
     */
    public function getSavedAt()
    {
        return $this->attributes['saved_at'];
    }


    /**
     * @return string
     */
    public function getSavedAtAsTimestamp()
    {
        return $this->getSavedAt()->getTimestamp();
    }


    /**
     * @return string
     */
    public function getFilename()
    {
        return $this->name . '-' . $this->getKey() . '.' . $this->extension;
    }


    /**
     * @inheritdoc
     */
    public function getFilePath()
    {
        return $this->getPath() . $this->getFilename();
    }


    /**
     * @inheritdoc
     */
    public function getUrl(array $options = [])
    {
        return FileManager::getFileUrl($this, $options);
    }


    /**
     * @return string
     */
    private function getPath()
    {
        return isset($this->path) ? $this->path . '/' : '';
    }


    /**
     * @inheritdoc
     */
    public function toArray()
    {
        return array_merge(parent::toArray(), ['url' => $this->getUrl()]);
    }


    /**
     * @param string $id
     *
     * @return File
     */
    public static function findByFileId($id)
    {
        return self::where('file_id', $id)->first();
    }
}
