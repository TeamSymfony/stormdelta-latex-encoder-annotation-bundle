<?php

namespace StormDelta\LatexEncoder\AnnotationBundle\Encoder;

class LatexEncoder
{
    public function encode($string)
    {
        $string = $this->stdEncode($string);
        $string = $this->htmlEncode($string);

        return $string;
    }

    private function stdEncode($string)
    {
        $string = str_replace('%', '\%', $string);

        return $string;
    }

    private function htmlEncode($string)
    {
        $string = str_replace('&euml;', '\"e', $string);
        $string = str_replace('&ecute;', '\\\'e', $string);
        $string = str_replace('&egrave;', '\`e', $string);

        return $string;
    }
}
