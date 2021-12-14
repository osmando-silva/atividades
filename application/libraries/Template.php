<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Template {
    
    function showLogin($view, $data = array()){
        
        $CI = & get_instance();
        $html = $CI->load->view('template/header_login', $data, TRUE);
        $html .= $CI->load->view($view, $data, TRUE);
        $html .= $CI->load->view('template/footer', '',TRUE);
        echo $html;
        
    }
    
    function show($view, $data = array()){
        
        $CI = & get_instance();
        $html = $CI->load->view('template/header', $data, TRUE);
        $html .= $CI->load->view('template/menu', '', TRUE);
        $html .= $CI->load->view($view, $data, TRUE);
        $html .= $CI->load->view('template/footer', '',TRUE);
        echo $html;
        
    }
    
}
