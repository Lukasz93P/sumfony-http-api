<?php
declare(strict_types=1);


namespace Lukasz93P\SymfonyHttpApi\filesStorage;


class StoredFile
{
    private string $contentType;

    private string $body;

    public static function fromContentTypeAndBody(string $contentType, string $body): self
    {
        return new self($contentType, $body);
    }

    private function __construct(string $contentType, string $body)
    {
        $this->contentType = $contentType;
        $this->body = $body;
    }

    public function contentType(): string
    {
        return $this->contentType;
    }

    public function body(): string
    {
        return $this->body;
    }

}