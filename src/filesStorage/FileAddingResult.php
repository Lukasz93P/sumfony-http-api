<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;


use InvalidArgumentException;

class FileAddingResult
{
    private string $newPath;

    public static function fromNewPath(string $newPath): self
    {
        if (empty($newPath)) {
            throw new InvalidArgumentException('Path of newly added file cannot be empty.');
        }

        return new self($newPath);
    }

    private function __construct(string $newPath)
    {
        $this->newPath = $newPath;
    }

    public function newPath(): string
    {
        return $this->newPath;
    }

}