<?php namespace Nord\Lumen\FileManager\Doctrine\ODM;

use Doctrine\ODM\MongoDB\DocumentManager;
use Doctrine\ODM\MongoDB\DocumentRepository;
use Nord\Lumen\FileManager\Contracts\File as FileContract;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContract;

class FileStorage implements FileStorageContract
{

    /**
     * @var DocumentManager
     */
    private $documentManager;

    /**
     * @var DocumentRepository
     */
    private $repository;


    /**
     * FileStorage constructor.
     *
     * @param DocumentManager $documentManager
     */
    public function __construct(DocumentManager $documentManager)
    {
        $this->documentManager = $documentManager;

        $this->repository = $this->documentManager->getRepository(File::class);
    }


    /**
     * @inheritdoc
     */
    public function saveFile(FileContract $file)
    {
        $this->documentManager->persist($file);
        $this->documentManager->flush();

        return $file;
    }


    /**
     * @inheritdoc
     */
    public function getFile($id)
    {
        return $this->repository->findOneBy(['id' => $id]);
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

        $this->documentManager->remove($file);
        $this->documentManager->flush();

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
