<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage\exceptions;


use Throwable;

interface FilesStorageException extends Throwable
{
    public static function fromFilePathAndReason(string $filePath, Throwable $reason): FilesStorageException;
}