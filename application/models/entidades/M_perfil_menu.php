<?php

if (!defined('BASEPATH')) {exit('Acesso direto ao arquivo n?o autorizado, log gerado!');}

/**
 * Classe de Entidade - Tabela PERFIL
 * @since 01/12/2016
 * @author ST Osmando
 * @package models
 * */
class M_perfil_menu extends M_entidade {
    
    private $codigo;
    private $campos;
    
    function __construct($codigo = NULL){
        
        parent::__construct();
        
        $this->set_tabela('PERFIL_MENU');
        $this->set_chavePrimaria('CODIGO');
        
        if ($codigo){
            
            $this->codigo = $codigo;
            
            $this->campos = $this->selecionaPerfilMenu();
            
        }
                        
    }
    
    public function get_campos(){
        
        return $this->campos;
        
    }
    
    public function selecionaPerfilMenu(){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        $this->db->where($this->get_chavePrimaria(), $this->codigo);
        
        return $this->db->get()->row();
        
    }
     
}