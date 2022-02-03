<?php

namespace Gonzalezoda\JsonToCode\Test;

use Gonzalezoda\JsonToCode\Processor;
use PHPUnit\Framework\TestCase;

class ProcessorTest extends TestCase
{
    public function testProcess1()
    {

        $json = <<<EOF
        {
          "foo": "bar"
        }
        EOF;

        $expected = implode('\n', [
            "[",
            "    'foo' => 'bar'",
            "]"
        ]);
        $this->assertSame($expected, (new Processor(json_decode($json, true)))->get());
    }

    public function testProcess2()
    {
        $json = <<<EOF
        {
          "foo": {
            "bar": "baz"
          }
        }
        EOF;

        $expected = implode('\n', [
            "[",
            "    'foo' => [",
            "        'bar' => 'baz'",
            "    ]",
            "]"
        ]);
        $this->assertSame($expected, (new Processor(json_decode($json, true)))->get());
    }

    public function testProcess3()
    {
        $json = <<<EOF
        [
          {
            "foo": "bar"
          }
        ]
        EOF;

        $expected = implode('\n', [
            "[",
            "    [",
            "        'foo' => 'bar'",
            "    ]",
            "]"
        ]);
        $this->assertSame($expected, (new Processor(json_decode($json, true)))->get());
    }

    public function testProcess4()
    {
        $json = <<<EOF
        [
          {
            "foo": "bar"
          },
          {
            "foo": "bar"
          }
        ]
        EOF;

        $expected = implode('\n', [
            "[",
            "    [",
            "        'foo' => 'bar'",
            "    ],",
            "    [",
            "        'foo' => 'bar'",
            "    ]",
            "]"
        ]);
        $this->assertSame($expected, (new Processor(json_decode($json, true)))->get());
    }

    public function testProcess5()
    {
        $json = <<<EOF
        {
          "foo": "bar",
          "baz": "boo"
        }
        EOF;

        $expected = implode('\n', [
            "[",
            "    'foo' => 'bar',",
            "    'baz' => 'boo'",
            "]"
        ]);
        $this->assertSame($expected, (new Processor(json_decode($json, true)))->get());
    }
}