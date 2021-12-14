<?php

if (!defined('BASEPATH')) {exit('Acesso direto ao arquivo não autorizado, log gerado!');}

/**
 * Classe de Entidade 
 * @since 2021
 * @author Osmando Silva
 * @package models
 * */
class M_atividades extends M_entidade {
    
    private $codigo;
    private $campos;
    
    function __construct($codigo = NULL){
        
        parent::__construct();
        
        $this->set_tabela('ATIVIDADES');
        $this->set_chavePrimaria('CODIGO');
        
        if ($codigo){
            
            $this->codigo = $codigo;
            
            $this->campos = $this->selecionaAtividade();
            
        }
                        
    }
    
    public function get_campos(){
        
        return $this->campos;
        
    }
    
    public function selecionaAtividade(){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        $this->db->where($this->get_chavePrimaria(), $this->codigo);
        
        return $this->db->get()->row();
        
    }
    
    public function selecionaAtividades($status = M_Constantes::Aberta){
        
        $this->db->select('CODIGO, TITULO, DESCRICAO, TIPO_CODIGO');
        $this->db->from($this->get_tabela());
        $this->db->where("STATUS", $status);
        
        return $this->db->get()->result();
        
    }
    
    public function selecionaAtividadesImpressao($status){
        
        $this->db->select("A.TITULO, A.DESCRICAO, T.DESCRICAO TIPO");
        $this->db->from($this->get_tabela()." A");
        $this->db->join('TIPO T', 'T.CODIGO = A.TIPO_CODIGO','inner', FALSE);
        $this->db->where("A.STATUS", $status);
        
        return $this->db->get()->result();
        
    }
     
}