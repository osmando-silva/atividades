<?php if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');
 
/**
* class C_Acesso_Negado
* 
*/

class C_acesso_negado extends S_Controller 
{


    public function __contruct( ) {

        parent::__construct();
                
    } 
    
    public function index(){
        
        $this->template->show('v_acesso_negado');
    
    }
           
}