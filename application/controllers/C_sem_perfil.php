<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_sem_perfil extends S_Controller {
    
    function __construct(){
        
        parent::__construct();
        
        if(!$this->session->userdata('logado')){

            redirect(); 

        }
        
    }
    
    public function index(){
        
        $this->template->show('administracao/v_sem_perfil');
        
    }
        
}