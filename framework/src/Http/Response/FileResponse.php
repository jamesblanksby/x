<?php

namespace Framework\Http\Response;

use Framework\Http\Exception\NotFoundException;

class FileResponse extends Response
{
    /** @var string */
    private $path;
    /** @var string */
    private $name;
    /** @var bool */
    private $download;

    public function __construct(string $path, ?string $name = null, bool $download = false)
    {
        parent::__construct();

        $this->path = $path;
        $this->name = $name ?? basename($path);
        $this->download = $download;
    }

    public function send(): void
    {
        if (!file_exists($this->path)) {
            throw new NotFoundException("File `{$this->path}` not found.");
        }

        $this->sendStatus();

        if (!$this->headersSent()) {
            $this->addHeaders();
            $this->sendHeaders();
        }

        $this->sendFile();
    }

    private function addHeaders(): void
    {
        $mime = mime_content_type($this->path) ?: 'application/octet-stream';
        $size = filesize($this->path);
        $disposition = $this->download ? 'attachment' : 'inline';

        $this->setHeader('content-type', $mime);
        $this->setHeader('content-length', (string) $size);
        $this->setHeader('content-disposition', "{$disposition}; filename=\"{$this->name}\"");
        $this->setHeader('cache-control', 'no-cache, must-revalidate');
    }

    private function sendFile(): void
    {
        readfile($this->path);
    }
}
