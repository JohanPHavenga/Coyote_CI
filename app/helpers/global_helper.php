<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('wts')) 
{
    function wts($seq = '')
    {
        echo "<pre>";
        print_r($seq);
        echo "</pre>";
    }
}

    