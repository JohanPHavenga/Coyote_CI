<?php

Class Seo extends CI_Controller {

    function sitemap()
    {
        $this->load->model('event_model');
        $confirmed_races_url_list=$this->event_model->get_event_list_sitemap(['confirmed'=>1]);        
        $upcoming_3months_url_list=$this->event_model->get_event_list_sitemap(['upcoming_3months'=>1]);
        $upcoming_older_url_list=$this->event_model->get_event_list_sitemap(['upcoming_older'=>1]);
        $results_url_list=$this->event_model->get_event_list_sitemap(['results'=>1]);
        $old_url_list=$this->event_model->get_event_list_sitemap(['old'=>1]);
        
//        wts($old_url_list);
//        die();
        
        $data["pages"]=[];
        
        // high level pages
        $data["pages_high"]=[
            ["url"=>"","change_freq"=>"weekly","priority"=>"1"],
            ["url"=>"event","change_freq"=>"weekly","priority"=>"0.9"],
            ["url"=>"event/calendar","change_freq"=>"weekly","priority"=>"0.9"],
            ];
        $data["pages"]=array_merge_recursive($data['pages'],$data['pages_high']);
        
        // area pages
        $data["pages_area"]=[
            ["url"=>"capetown","change_freq"=>"weekly","priority"=>"0.8"],
            ["url"=>"gardenroute","change_freq"=>"weekly","priority"=>"0.8"],
            ["url"=>"westcoast","change_freq"=>"weekly","priority"=>"0.8"],
            ["url"=>"winelands","change_freq"=>"weekly","priority"=>"0.8"],
            ["url"=>"overberg","change_freq"=>"weekly","priority"=>"0.8"],
            ];        
        $data["pages"]=array_merge_recursive($data['pages'],$data['pages_area']);
        
        // confirmed races
        foreach ($confirmed_races_url_list as $key=>$url) {
            $data['pages_confirmed'][$key]['url']=$url;
            $data['pages_confirmed'][$key]['change_freq']="weekly";
            $data['pages_confirmed'][$key]['priority']="0.8";
        }        
        $data["pages"]=array_merge_recursive($data['pages'], $data['pages_confirmed']);
        
        // upcoming next 3 month races
        foreach ($upcoming_3months_url_list as $key=>$url) {
            $data['pages_upcoming'][$key]['url']=$url;
            $data['pages_upcoming'][$key]['change_freq']="weekly";
            $data['pages_upcoming'][$key]['priority']="0.7";
        }        
        $data["pages"]=array_merge_recursive($data['pages'], $data['pages_upcoming']);
        
        // upcoming races
        foreach ($upcoming_older_url_list as $key=>$url) {
            $data['pages_upcoming'][$key]['url']=$url;
            $data['pages_upcoming'][$key]['change_freq']="monthly";
            $data['pages_upcoming'][$key]['priority']="0.5";
        }        
        $data["pages"]=array_merge_recursive($data['pages'], $data['pages_upcoming']);
        
        // races with results
        foreach ($results_url_list as $key=>$url) {
            $data['pages_results'][$key]['url']=$url;
            $data['pages_results'][$key]['change_freq']="yearly";
            $data['pages_results'][$key]['priority']="0.3";
        }        
        $data["pages"]=array_merge_recursive($data['pages'], $data['pages_results']);
        
        // old races
        foreach ($old_url_list as $key=>$url) {
            $data['pages_old'][$key]['url']=$url;
            $data['pages_old'][$key]['change_freq']="never";
            $data['pages_old'][$key]['priority']="0.1";
        }        
        $data["pages"]=array_merge_recursive($data['pages'], $data['pages_old']);
        
        
//        wts($data["pages"]);
//        die();
        
        $data['events_upcoming']=[];   
        $data['events_results']=[];   
        $data['events_past']=[];
        
        header("Content-Type: text/xml;charset=iso-8859-1");
        $this->load->view("sitemap",$data);
    }
}

