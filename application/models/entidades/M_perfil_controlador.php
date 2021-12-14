<?php

if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

/**
 * Classe de Entidade - Tabela PERFIL_CONTROLADOR
 * @since 2018
 * @author ST Osmando
 * @package models
 * */
class M_perfil_controlador extends M_entidade {
    
    private $codigo;
    private $campos;
    
    function __construct($codigo = NULL){
        
        parent::__construct();
        
        $this->set_tabela('PERFIL_CONTROLADOR');
        $this->set_chavePrimaria('CODIGO');
        
        $this->codigo = $codigo;
            
        $this->campos = $this->selecionaPerfilControlador();
                      
    }
    
    public function get_campos(){
        
        return $this->campos;
        
    }
    
    public function selecionaPerfilControlador(){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        $this->db->where('CONTROLADOR_CODIGO', $this->codigo);
        
        return $this->db->get()->result();
        
    }
    
}