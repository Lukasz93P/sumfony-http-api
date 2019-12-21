<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;


use App\application\shared\filesStorage\exceptions\FileRetrievingFailed;
use App\application\shared\filesStorage\exceptions\FileAddingFailed;

interface FilesStorage
{
    /**
     * @param FileToStore $fileToStore
     * @param string $destinationPath
     * @return string
     * @throws FileAddingFailed
     */
    public function add(FileToStore $fileToStore, string $destinationPath): string;

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