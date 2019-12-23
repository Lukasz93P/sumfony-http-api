<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;


use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileAddingFailed;
use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileRetrievingFailed;

interface FilesStorage
{
    /**
     * @param FileToStore $fileToStore
     * @param string $destinationPath
     * @return FileAddingResult
     * @throws FileAddingFailed
     */
    public function add(FileToStore $fileToStore, string $destinationPath): FileAddingResult;

    /**
     * @param string $filePath
     * @return StoredFile
     * @throws FileRetrievingFailed
     */
    public function get(string $filePath): StoredFile;

    /**
     * @param string $filePath
     */
    public function remove(string $filePath): void;
}