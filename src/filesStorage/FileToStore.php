<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;


class FileToStore
{
    private string $path;

    private string $name;

    public static function fromPathAndOriginalName(string $path, string $originalName): self
    {
        return new self($path, $originalName);
    }

    private function __construct(string $path, string $name)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getName(): string
    {
        return $this->name;
    }

}