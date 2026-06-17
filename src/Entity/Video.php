<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

class Video
{
    public readonly int $id;
    public readonly string $url;
    private ?string $filePath = null;
    private bool $filePathChanged = false;

    public function __construct(
        string $url,
        public readonly string $title,
    ) {
        $this->setUrl($url);
    }

    private function setUrl(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException();
        }

        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
        $this->filePathChanged = true;
    }

    public function loadFilePath(string $filePath): void
    {
        $this->filePath = $filePath;
        $this->filePathChanged = false;
    }

    public function removeFilePath(): void
    {
        $this->filePath = null;
        $this->filePathChanged = true;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function filePathChanged(): bool
    {
        return $this->filePathChanged;
    }
}
