<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 
class C_impressao extends S_Controller {
    
    function __construct(){
        
        parent::__construct();
        
        if(!$this->session->userdata('logado')){

            redirect('c_principal','refresh'); 

        }
                
    }
    
    function apagaRelatorios(){
        
        $pasta = opendir (PATH_REL);
        
        while ($arquivo = readdir ($pasta)){
            
            if (strpos($arquivo, '-'.$this->session->userdata('usuarioCodigo'))){
                
                unlink(PATH_REL.$arquivo); 
            
            }   
        } 
        
        closedir($pasta);
        
    }
    
}