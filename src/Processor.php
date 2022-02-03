<?php

namespace Gonzalezoda\JsonToCode;

class Processor
{
    protected array $contents = [];
    protected int $processedElementCount = 0;

    public function __construct(protected array $text) {}

    private function process(array $text)
    {
        foreach ($text as $k => $v) {
            if (is_string($k) && is_string($v)) {
                Depth::inc();
                $this->processedElementCount++;
                if (count($text) !== $this->processedElementCount) {
                    $this->contents[] = sprintf("%s'{$k}' => '{$v}',", Depth::space());
                } else {
                    $this->contents[] = sprintf("%s'{$k}' => '{$v}'", Depth::space());
                    $this->processedElementCount = 0;
                }
                Depth::dec();
            } elseif (is_string($k) && is_array($v)) {
                Depth::inc();
                $this->contents[] = sprintf("%s'{$k}' => [", Depth::space());
                $this->process($v);
                $this->contents[] = sprintf("%s]", Depth::space());
                Depth::dec();
            } elseif (is_int($k) && is_array($v)) {
                Depth::inc();
                $this->contents[] = sprintf("%s[", Depth::space());
                $this->process($v);
                if (isset($text[$k + 1])) {
                    $this->contents[] = sprintf("%s],", Depth::space());
                } else {
                    $this->contents[] = sprintf("%s]", Depth::space());
                }
                Depth::dec();
            }
        }
    }

    public function get(): string
    {
        $this->contents[] = '[';
        $this->process($this->text);
        $this->contents[] = ']';

        return implode('\n', $this->contents);
    }
}