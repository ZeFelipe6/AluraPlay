<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

class Video
{
    public string $url;
    public int $id;
    public string $title;

    public function __construct(string $url, string $title)
    {
        $this->setUrl($url);
        $this->title = $title;
    }

    private function setUrl(string $url): void
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
}
