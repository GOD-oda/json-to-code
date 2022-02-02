<?php

namespace Gonzalezoda\JsonToCode;

class Processor
{
    protected array $contents = [];

    public function __construct(protected array $text) {}

    private function process(array $text, $crlf = false)
    {
        foreach ($text as $k => $v) {
            if (is_string($k) && is_string($v)) {
                if (!$crlf) {
                    $this->contents[] = sprintf("%s[", Depth::space());
                }
                Depth::inc();
                $this->contents[] = sprintf("%s'{$k}' => '{$v}'", Depth::space());
                Depth::dec();
                if (!$crlf) {
                    $this->contents[] = sprintf("%s]", Depth::space());
                }
            } elseif (is_string($k) && is_array($v)) {
                if (!$crlf) {
                    $this->contents[] = sprintf("%s[", Depth::space());
                }
                Depth::inc();
                $this->contents[] = sprintf("%s'{$k}' => [", Depth::space());
                $this->process($v, true);
                $this->contents[] = sprintf("%s]", Depth::space());
                Depth::dec();
                if (!$crlf) {
                    $this->contents[] = sprintf("%s]", Depth::space());
                }
            } elseif (is_int($k) && is_array($v)) {
                $this->contents[] = sprintf("%s[", Depth::space());
                Depth::inc();
                $this->contents[] = sprintf("%s[", Depth::space());
                $this->process($v, true);
                $this->contents[] = sprintf("%s]", Depth::space());
                Depth::dec();
                $this->contents[] = sprintf("%s]", Depth::space());
            }
        }
    }

    public function get(): string
    {
        $this->process($this->text);

        return implode('\n', $this->contents);
    }
}