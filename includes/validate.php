<?php

function is_number($number, $min = 0, $max = 100): bool
{
    return ($number >= $min and $number <= $max);
}

function is_text($text, $min = 0, $max = 1000):string
{
    $length = mb_strlen($text);
    return ($length >= $min and $length <= $max);
}

function html_escape(string $string): string
{
    return htmlspecialchars($string,ENT_QUOTES|ENT_HTML5, 'UTF-8', true);
}