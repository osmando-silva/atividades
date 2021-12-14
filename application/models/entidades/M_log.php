<?php

if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

/**
 * Classe de Entidade - Tabela LOG
 * @since 05/05/2017
 * @author ST Osmando
 * @package models
 * */
class M_Log extends M_entidade {
    
    function __construct() {
        
        parent::__construct();
        $this->set_tabela('LOG');
        $this->set_chavePrimaria('CODIGO');
        
    }

    public function gravaLog($acao, $usuarioCodigo){
        
        $ipOrigem = $this->input->ip_address();
        
        $acao = str_replace("'", "\'", $acao);
        
        $dados = array('ACAO'=>"'$acao'",
                       'IP_ORIGEM'=>"'$ipOrigem'",
                       'USUARIO_CODIGO'=>$usuarioCodigo
                      );
        
        try{
            
            $this->db->insert($this->get_tabela(), $dados, FALSE);
            
            return TRUE;
              
        }catch (Exception $ex) {

            return $ex->getMessage();

        }
        
    }
    
    public function selecionaAnosLog(){
        
        $this->db->select("DISTINCT YEAR(DATA_LOG) ANO", FALSE);
        $this->db->from('LOG');
             
        $this->db->order_by('ANO DESC');
        
        return $this->db->get()->result();
        
    }
    
    public function selecionaUsuarios($ano){
        
        $this->db->select("DISTINCT L.USUARIO_CODIGO CODIGO, U.NOME, CASE WHEN L.USUARIO_CODIGO = 0 THEN 'Sistema' ELSE U.NOME END USUARIO, ", FALSE);

        $this->db->from('LOG L');
        $this->db->join('USUARIO U', 'U.CODIGO = L.USUARIO_CODIGO','left', FALSE);
        $this->db->where("YEAR(L.DATA_LOG) = '$ano'");
        
        $this->db->order_by('U.NOME', FALSE);
        
        return $this->db->get()->result();
        
    }
    
    public function consultarLogFiltrado($ano, $usuarioCodigo, $dataIni, $dataFim){
        
        $this->db->select("L.CODIGO, L.DATA_LOG, L.IP_ORIGEM, L.ACAO, U.LOGIN, "
                . "CASE WHEN L.USUARIO_CODIGO = 0 THEN 'Sistema' ELSE U.NOME END USUARIO");
        $this->db->from($this->get_tabela().' L');
        $this->db->join('USUARIO U', 'U.CODIGO = L.USUARIO_CODIGO','left', FALSE);
        $this->db->where("YEAR(DATA_LOG) = '$ano'");
        
        if ($usuarioCodigo != ''){
            
            $this->db->where('L.USUARIO_CODIGO', $usuarioCodigo, FALSE);
            
        }
                
        if ($dataIni != ''){
            
            $this->db->where('DATE(L.DATA_LOG) >=', $dataIni);
            
        }
        
        if ($dataFim != ''){
            
            $this->db->where('DATE(L.DATA_LOG) <=', $dataFim);
            
        }
        
        $this->db->order_by('L.DATA_LOG', 'ASC', FALSE);
        $this->db->order_by('L.USUARIO_CODIGO', 'ASC', FALSE);
        
        return $this->db->get()->result();
        
    }
        
}