<?php

if(!function_exists('onlyNums')) {
    function onlyNums(string $string) : int
    {
        return (int) preg_replace('/\D/', '', $string);
    }
}
