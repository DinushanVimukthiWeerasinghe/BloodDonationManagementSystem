<?php
namespace Core;
class Response
{
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }

    public function redirect(string $url)
    {
        header('Location: ' . $url);
    }

    public function getContentType(string $path): string
    {
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                return 'image/jpeg';
            case 'png':
                return 'image/png';
            case 'gif':
                return 'image/gif';
            case 'css':
                return 'text/css';
            case 'js':
                return 'text/javascript';
            case 'json':
                return 'application/json';
            case 'xml':
                return 'application/xml';
            case 'html':
                return 'text/html';
            case 'svg':
                return 'image/svg+xml';
            case 'txt':
                return 'text/plain';
            default:
                return 'application/octet-stream';
        }

    }

    public function sendFile(string $string): bool|int
    {
        return readfile($string);
    }

    public function setContentType(string $string): void
    {
        header('Content-Type: ' . $string);
    }

    public function setContentLength(bool|int $filesize): void
    {
        header('Content-Length: ' . $filesize);
    }

    public function setContent(bool|string $json_encode)
    {
        header('Content : ' . $json_encode);
    }


}