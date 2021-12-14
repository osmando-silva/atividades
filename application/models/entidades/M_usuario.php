<?php

if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

/**
 * Classe de Entidade - Tabela USUARIO
 * @since 01/12/2016
 * @author ST Osmando
 * @package models
 * */
class M_usuario extends M_entidade {
    
    private $codigo;
    private $posto;
    private $om;
    private $perfilCodigos;
    private $perfilDatafim;
                    
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
    
    public function get_perfilDataFim(){
        
        return $this->perfilDatafim;
        
    }
    
    public function get_perfilCodigos(){
        
        return $this->perfilCodigos;
        
    }
    
    public function dadosUsuario($login){
        
        $this->db->select('CODIGO, ATIVO');
        $this->db->from('USUARIO');
        $this->db->where('LOGIN', $login);
        
        return $this->db->get()->row();
                        
    }
    
    public function selecionaUsuario(){
        
        $this->load->model('entidades/m_usuario_perfil');
        
        $usuarioPerfis = new M_usuario_perfil($this->codigo);
        
        $perfilCodigos = $usuarioPerfis->get_campos();
        
        if (empty($perfilCodigos)){
            
        }else{
            
            foreach ($perfilCodigos as $perfilCodigo){
            
                $this->perfilCodigos[] = $perfilCodigo->PERFIL_CODIGO;

                $this->perfilDatafim[$perfilCodigo->PERFIL_CODIGO] = $perfilCodigo->DATA_FIM;

            }
            
        }
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        $this->db->where($this->get_chavePrimaria(), $this->codigo);
        
        $this->campos = $this->db->get()->row();
        
    }
    
    public function selecionaLinhaUsuario($codigo){
        
        $this->db->select('U.NOME_DE_GUERRA, P.ABREVIATURA POSTO', FALSE);
        $this->db->from($this->get_tabela().' U', FALSE);
        $this->db->join('POSTO P', 'P.CODIGO = U.POSTO_CODIGO','inner', FALSE);
        $this->db->where('U.CODIGO', $codigo, FALSE);
        
        return $this->db->get()->row();
        
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