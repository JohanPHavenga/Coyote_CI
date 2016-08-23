<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ================================================================
// Formulate Dates
// ================================================================
if ( ! function_exists('fdateShort'))
{
    function fdateShort($date) 
    {
        if ($date)
        {
            return date("Y-m-d",strtotime($date));
        } else {
            return false;
        }
    }
}

if ( ! function_exists('fdateLong'))
{
    function fdateLong($date, $show_sec=TRUE) 
    {
        if ($date)
        {
            if ($show_sec) 
            {
                return date("Y-m-d H:i:s",strtotime($date));
            } else {
                return date("Y-m-d H:i",strtotime($date));
            }
        } else {
            return false;
        }
    }
}

if ( ! function_exists('fdateYear'))
{
    function fdateYear($date) 
    {
        if ($date)
        {
            return date("Y",strtotime($date));
        } else {
            return false;
        }
    }
}

// ================================================================
// Formulate Buttons
// ================================================================
if ( ! function_exists('fbutton')) 
{
    function fbutton($text="Submit",$type="submit",$status="default",$size=NULL) 
    {
        // status: default|primary|success|warning|danger|link
        // size: lg|sm|xs
        
        if ($size)
        {
            $btn_size="btn-".$size;
        } 
        else 
        {
            $btn_size=NULL;
        }
        return "<button type='$type' class='btn btn-$status $btn_size'>$text</button>";
    }
}

if ( ! function_exists('fbuttonLink')) 
{
    function fbuttonLink($url,$text,$status="default",$size=NULL) 
    {
        // status: default|primary|success|warning|danger|link
        // size: lg|sm|xs        
        if ($size)
        {
            $btn_size="btn-".$size;
        } 
        else 
        {
            $btn_size=NULL;
        }
        return "<a href='$url' class='btn btn-$status $btn_size' role='button'>$text</a>";
    }
}


// ====================================s============================
// Formulate Tables
// ================================================================

if ( ! function_exists('ftable')) 
{
    function ftable() 
    {
        $template = array(
                'table_open' => '<table class="table table-striped table-bordered table-condensed ">'
        );
        return $template;
    }
}


if ( ! function_exists('ftableHeading')) 
{   
    function ftableHeading($heading_list,$blank_columns=0) 
    {
        foreach ($heading_list as $heading):
            $fheading_list[]=str_replace("Id","ID",str_replace("_", "&nbsp;", ucwords($heading,"_")));
        endforeach;        
        $return['heading']= $fheading_list; 
        
        for ($n = 0; $n < $blank_columns; $n++) 
        {
            $return['heading'][] = "";
        }
        return $return['heading'];
    }
}


// ================================================================
// Formulate Pagenation
// ================================================================
if ( ! function_exists('fpagination')) 
{
    function fpagination($p) 
    {
        return $p;
    }
}

if ( ! function_exists('fpaginationConfig')) 
{
    function fpaginationConfig($url,$per_page,$total,$uri_segment) 
    {
        $config["base_url"] = $url;
        $config["total_rows"] = $total;
        $config["per_page"] = $per_page;
        $config["uri_segment"] = $uri_segment;
        
        $config['full_tag_open'] = '<nav aria-label="Page navigation"><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        
        $config['next_link'] = "Next &rsaquo;";
        $config['prev_link'] = "&lsaquo; Previous";
        
        $open_tag_list=['first_tag_open','next_tag_open','prev_tag_open','last_tag_open','num_tag_open'];
        foreach ($open_tag_list as $tag):
            $config[$tag]='<li>';
        endforeach;
        
        $open_tag_list=['first_tag_close','next_tag_close','prev_tag_close','last_tag_close','num_tag_close'];
        foreach ($open_tag_list as $tag):
            $config[$tag]='</li>';
        endforeach;
        
        $config['cur_tag_open'] = "<li><a><b>";
        $config['cur_tag_close'] = "</b></a></li>";
        return $config;
    }
}