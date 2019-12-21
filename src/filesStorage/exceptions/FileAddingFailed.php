<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage\exceptions;


use Throwable;
use RuntimeException;

class FileAddingFailed extends RuntimeException
{
    public static function fromFilePathAndReason(string $filePath, Throwable $reason): self
    {
        return new self("Adding of file $filePath failed, reason: " . $reason->getMessage(), $reason->getCode(), $reason);
    }

    private function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}