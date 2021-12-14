<?php

if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

/**
 * Classe de Entidade - Tabela USUARIO
 * @since 01/12/2016
 * @author ST Osmando
 * @package models
 * */
class M_usuarios extends M_entidade {
    
    private $codigo;
                            
    function __construct($codigo = NULL){
        
        parent::__construct();
        
        $this->set_tabela('USUARIO');
        $this->set_chavePrimaria('CODIGO');
        
        if ($codigo){
            
            $this->codigo = $codigo;
            
            $this->selecionaUsuario();
            
        }
        
    }
    
    public function get_campos(){
        
        return $this->campos;
        
    }
    
    public function set_perfilCodigos(M_usuario_perfil $perfilCodigos){
        
        $this->perfilCodigos[] = $perfilCodigos;
        
    }
    
    public function get_perfilCodigos(){
        
        return $this->perfilCodigos;
        
    }
    
    public function selecionaUsuario(){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        $this->db->where($this->get_chavePrimaria(), $this->codigo);
        
        $this->campos = $this->db->get()->row();
        
    }
    
    public function colecaoUsuarios($key, $criterios_in = null, $order_by = null){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
                
        if ($criterios_in){
            
            $this->db->where_in($key, $criterios_in);
       
        }
        
        if ($order_by){
            
            foreach ($order_by as $valor){
            
                $this->db->order_by($valor, '', FALSE);

            }
                        
        }
        
        return $this->db->get()->result();
                
    }
    
    public function atualizarSenha($usuarioCodigo, $senha){
        
        $sql = "UPDATE USUARIO SET SENHA = '$senha' WHERE CODIGO = $usuarioCodigo";
        
        try{
            
            $this->db->query($sql);
            
            return TRUE;

        }catch (Exception $ex) {

            return $ex->getMessage();

        }
        
    }
    
}