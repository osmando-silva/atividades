<?php

if (!defined('BASEPATH')) {exit('Acesso direto ao arquivo não autorizado, log gerado!');}

/**
 * Classe de Entidade - Tabela USUARIO_PERFIL
 * @since 01/12/2016
 * @author ST Osmando
 * @package models
 * */
class M_usuario_perfil extends M_entidade {
    
    private $codigo;
    private $campos;
    
    function __construct($codigo = NULL){
        
        parent::__construct();
        
        $this->set_tabela('USUARIO_PERFIL');
        $this->set_chavePrimaria('CODIGO');
        
        if ($codigo){
            
            $this->codigo = $codigo;
            
            $this->campos = $this->selecionaUsuarioPerfil();
            
        }
                        
    }
    
    public function get_campos(){
        
        return $this->campos;
        
    }
    
    public function perfis($usuarioCodigo){
        
        $this->db->select("P.*");
        $this->db->from($this->get_tabela().' UP');
        $this->db->join('PERFIL P', 'P.CODIGO = UP.PERFIL_CODIGO','inner', FALSE);
        $this->db->where('UP.USUARIO_CODIGO', $usuarioCodigo);
        $this->db->where("(UP.DATA_FIM IS NULL OR UP.DATA_FIM >= (SELECT DATE_FORMAT(SYSDATE(), '%Y-%m-%d')))");
        $this->db->order_by('CODIGO', 'ASC');
        
        return $this->db->get()->result();
        
    }
    
    public function selecionaUsuarioPerfil(){
        
        $this->db->select("*");
        $this->db->from($this->get_tabela());
        $this->db->where('USUARIO_CODIGO', $this->codigo);
        $this->db->where("(DATA_FIM IS NULL OR DATA_FIM >= (SELECT DATE_FORMAT(SYSDATE(), '%Y-%m-%d')))");
        
        return $this->db->get()->result();
        
    }
     
}