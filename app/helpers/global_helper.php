<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


function wts($seq = '')
{
    echo "<pre>";
    print_r($seq);
    echo "</pre>";
}

function set_pagenation_config($base, $total_rows) {
    $config["base_url"] = base_url() . $base;
    $config["total_rows"] = $total_rows;
    $config["per_page"] = 50;
    $config["uri_segment"] = 2;
    $config["num_links"] = 5;
    $config['full_tag_open'] = "<p>";
    $config['full_tag_close'] = "</p>";
    $config['attributes'] = array('style' => 'padding: 0px 2px');
    
    return $config;
}
    
    