<?php

if (!defined('BASEPATH')) {exit('Acesso direto ao arquivo não autorizado, log gerado!');}

/**
 * Classe de Entidade 
 * @since 2021
 * @author Osmando Silva
 * @package models
 * */
class M_tipo_atividade extends M_entidade {
    
    private $codigo;
    private $campos;
    
    function __construct($codigo = NULL){
        
        parent::__construct();
        
        $this->set_tabela('TIPO');
        $this->set_chavePrimaria('CODIGO');
        
        if ($codigo){
            
            $this->codigo = $codigo;
            
            $this->campos = $this->selecionaTipo();
            
        }
                        
    }
    
    public function get_campos(){
        
        return $this->campos;
        
    }
    
    public function selecionaTipo(){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        $this->db->where($this->get_chavePrimaria(), $this->codigo);
        
        return $this->db->get()->row();
        
    }
     
}