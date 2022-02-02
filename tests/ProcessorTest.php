<?php

namespace Gonzalezoda\JsonToCode\Test;

use Gonzalezoda\JsonToCode\Processor;
use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    public function testProcess()
    {

        $json = <<<EOF
        {
          "foo": "bar"
        }
        EOF;

        $expected = implode('\n', [
            '[',
            '    \'foo\' => \'bar\'',
            ']'
        ]);
        $this->assertSame($expected, (new Processor(json_decode($json, true)))->get());

        $json = <<<EOF
        {
          "foo": {
            "bar": "baz"
          }
        }
        EOF;

        $expected = implode('\n', [
            '[',
            '    \'foo\' => [',
            '        \'bar\' => \'baz\'',
            '    ]',
            ']'
        ]);
        $this->assertSame($expected, (new Processor(json_decode($json, true)))->get());
    }
}