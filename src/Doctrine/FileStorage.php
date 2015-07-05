<?php namespace Nord\Lumen\FileManager\Doctrine;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Nord\Lumen\FileManager\Contracts\File as FileContract;
use Nord\Lumen\FileManager\Contracts\FileStorage as FileStorageContract;

class FileStorage implements FileStorageContract
{

    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var EntityRepository
     */
    private $repository;


    /**
     * FileStorage constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        $this->repository = $this->entityManager->getRepository(File::class);
    }


    /**
     * @inheritdoc
     */
    public function saveFile(FileContract $file)
    {
        $this->entityManager->persist($file);
        $this->entityManager->flush();

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

        $this->entityManager->remove($file);
        $this->entityManager->flush();

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
