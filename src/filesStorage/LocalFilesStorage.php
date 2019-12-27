<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;


use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileAddingFailed;
use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileRemovingFailed;
use Lukasz93P\SymfonyHttpApi\filesStorage\exceptions\FileRetrievingFailed;
use RuntimeException;

class LocalFilesStorage implements FilesStorage
{
    private string $destinationDirectory;

    public function __construct(string $destinationDirectory)
    {
        $this->destinationDirectory = $destinationDirectory;
    }

    public function add(FileToStore $fileToStore, string $destinationPath): FileAddingResult
    {
        $currentFilePath = $fileToStore->getPath();
        $fileExtension = pathinfo($fileToStore->getName(), PATHINFO_EXTENSION);
        $newPath = "{$this->destinationDirectory}\\$destinationPath.$fileExtension";
        if (!rename($currentFilePath, $newPath)) {
            throw FileAddingFailed::fromFilePathAndReason($currentFilePath, new RuntimeException('Cannot move file'));
        }

        return FileAddingResult::fromNewPath($newPath);
    }

    public function get(string $filePath): StoredFile
    {
        if (!file_exists($filePath)) {
            throw FileRetrievingFailed::fromFilePathAndReason($filePath, new RuntimeException('File does not exists'));
        }
        $contentType = mime_content_type($filePath);
        $fileBody = file_get_contents($filePath);
        if (empty($contentType) || empty($fileBody)) {
            throw FileRetrievingFailed::fromFilePathAndReason($filePath, new RuntimeException('File has been corrupted'));
        }

        return StoredFile::fromContentTypeAndBody($contentType, $fileBody);
    }

    public function remove(string $filePath): void
    {
        if (!unlink($filePath)) {
            throw FileRemovingFailed::fromFilePathAndReason($filePath, new RuntimeException('File removing failed'));
        }
    }

}