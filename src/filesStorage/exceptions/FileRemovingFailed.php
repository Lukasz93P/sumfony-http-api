<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage\exceptions;


use RuntimeException;
use Throwable;

class FileRemovingFailed extends RuntimeException implements FilesStorageException
{
    public static function fromFilePathAndReason(string $filePath, Throwable $reason): self
    {
        return new self("Removing of file $filePath failed, reason: " . $reason->getMessage(), $reason->getCode(), $reason);
    }

    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}