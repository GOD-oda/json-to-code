<?php

class Depth
{
    protected static $depth = 0;

    public static function inc()
    {
        self::$depth++;
    }

    public static function dec()
    {
        self::$depth--;
    }

    public static function space()
    {
        return str_repeat(' ', self::$depth * 4);
    }
}

function process(array $text, $crlf = false)
{
    foreach ($text as $k => $v) {
        if (is_string($k) && is_string($v)) {
            if (!$crlf) {
                echo sprintf("%s[\n", Depth::space());
            }
            Depth::inc();
            echo sprintf("%s'{$k}' => '{$v}'\n", Depth::space());
            Depth::dec();
            if (!$crlf) {
                echo sprintf("%s]\n", Depth::space());
            }
        } elseif (is_string($k) && is_array($v)) {
            if (!$crlf) {
                echo sprintf("%s[\n", Depth::space());
            }
            Depth::inc();
            echo sprintf("%s'{$k}' => [\n", Depth::space());
            process($v, true);
            echo sprintf("%s]\n", Depth::space());
            Depth::dec();
            if (!$crlf) {
                echo sprintf("%s]\n", Depth::space());
            }
        } elseif (is_int($k) && is_array($v)) {
            echo sprintf("%s[\n", Depth::space());
            Depth::inc();
            echo sprintf("%s[\n", Depth::space());
            process($v, true);
            echo sprintf("%s]\n", Depth::space());
            Depth::dec();
            echo sprintf("%s]\n", Depth::space());
        }
    }
}

$json = <<<EOF
{
  "foo": "bar"
}
EOF;
process(json_decode($json, true));

$json = <<<EOJ
{
  "foo": {
    "baz": "v"
  }
}
EOJ;
process(json_decode($json, true));

$json = <<<EOJ
[
  {
    "foo": {
      "bar": "baz"
    }
  }
]
EOJ;
process(json_decode($json, true));

$json = <<<EOJ
[
  {
    "foo": {
      "bar": {
        "baz": "v"
      }
    }
  }
]
EOJ;
process(json_decode($json, true));



