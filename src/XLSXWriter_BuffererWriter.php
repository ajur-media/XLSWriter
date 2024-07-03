<?php

namespace AJUR\Toolkit;

class XLSXWriter_BuffererWriter
{
    protected $fd = null;
    protected string $buffer = '';
    protected $check_utf8 = false;

    public function __construct($filename, $fd_fopen_flags = 'w', $check_utf8 = false)
    {
        $this->check_utf8 = $check_utf8;
        $this->fd = fopen($filename, $fd_fopen_flags);
        if ($this->fd === false) {
            XLSXWriter::log(sprintf('Unable to open %s for writing.', $filename));
        }
    }

    public function write(string $string): void
    {
        $this->buffer .= $string;
        if (isset($this->buffer[8191])) {
            $this->purge();
        }
    }

    protected function purge()
    {
        if ($this->fd) {
            if ($this->check_utf8 && !self::isValidUTF8($this->buffer)) {
                XLSXWriter::log("Error, invalid UTF8 encoding detected.");
                $this->check_utf8 = false;
            }

            fwrite($this->fd, $this->buffer);
            $this->buffer = '';
        }
    }

    public function close(): void
    {
        $this->purge();
        if ($this->fd) {
            fclose($this->fd);
            $this->fd = null;
        }
    }

    public function __destruct()
    {
        $this->close();
    }

    public function ftell()
    {
        if ($this->fd) {
            $this->purge();
            return ftell($this->fd);
        }

        return -1;
    }

    public function fseek($pos): int
    {
        if ($this->fd) {
            $this->purge();
            return fseek($this->fd, $pos);
        }

        return -1;
    }

    protected static function isValidUTF8($string): bool
    {
        if (empty($string)) {
            return true;
        }

        if (function_exists('mb_check_encoding')) {
            return mb_check_encoding($string, 'UTF-8');
        }

        return (bool) preg_match("//u", $string);
    }
}
