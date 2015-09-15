<?php namespace Nord\Lumen\FileManager\Doctrine\ODM;

use Doctrine\ODM\DocumentManagerInterface;
use Doctrine\ODM\DocumentRepository;
use Nord\Lumen\FileManager\Contracts\File as FileContract;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContract;

class FileStorage implements FileStorageContract
{

    /**
     * @var DocumentManagerInterface
     */
    private $documentManager;

    /**
     * @var DocumentRepository
     */
    private $repository;


    /**
     * FileStorage constructor.
     *
     * @param DocumentManagerInterface $documentManager
     */
    public function __construct(DocumentManagerInterface $documentManager)
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
        return $this->repository->findOneBy(['shortId' => $id]);
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
