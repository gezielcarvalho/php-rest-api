<?php

namespace Core;

class View
{
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);

        $file = "../app/views/$view";

        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file not found");
        }    
    }
}