<?php
//some legacy functions


function getProductFileLines($file) {
    //just imagine lots of custom logic here
    return file($file);
}

function getPriceFromLine($line)
{
    //just imagine lots of custom logic here
    if (preg_match('/^(\d{1,3})-/', $line, $array)) {
        return $array[1];
    }

    return -1;
}

function getNameFromLine($line)
{
    //just imagine lots of custom logic here
    if (preg_match('/.*-(.*)/', $line, $array)) {
        return  str_replace('_', ' ', $array[1]);
    }

    return '';
}