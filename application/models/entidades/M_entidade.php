<?php

if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

/**
 * Classe de Entidade - M_Entidade
 * @since 01/12/2016
 * @author ST Osmando
 * @package models
 * */
class M_entidade extends S_Model {
    
    private $tabela;
    private $campos;
    private $camposValores;
    private $criterios_and;
    private $criterios_in;
    private $key;
    private $criterios_not_in;
    private $criterios_or;
    private $chavePrimaria;
    private $campoAssociativa;
    private $order_by;
            
            
    function __construct($codigo = NULL){
        
        parent::__construct();
                
    }
    
    public function set_tabela($nome){
        
        $this->tabela = $nome;
        
    }
    
    public function get_tabela(){
        
        return $this->tabela;
        
    }
    
    public function set_chavePrimaria($chave){
        
        $this->chavePrimaria = $chave;
        
    }
    
    public function get_chavePrimaria(){
        
        return $this->chavePrimaria;
        
    }
    
    public function set_campos($campos){
        
        $this->campos = $campos;
           
    }
   
    public function set_camposValores($camposValores){
        
        $this->camposValores = $camposValores;
           
    }
    
    public function get_camposValores(){
        
        return $this->camposValores;
           
    }
    
    public function set_criterios_and(Array $criterios){
        
        $this->criterios_and = $criterios;
                
    }
    
    public function get_criterios_and(){
        
        return $this->criterios_and;
           
    }
    
    public function set_criterios_in($key, Array $criterios){
        
        $this->key = $key;
        
        $this->criterios_in = $criterios;
                
    }
    
    public function set_criterios_not_in($key, Array $criterios){
        
        $this->key = $key;
        
        $this->criterios_not_in = $criterios;
                
    }
    
    public function set_order_by(Array $order_by){
        
        $this->order_by = $order_by;
                
    }
    
    public function set_criterios_or($criterios){
        
        $this->criterios_or = $criterios;
                
    }
    
    public function set_campoAssociativa($nome){
        
        $this->campoAssociativa = $nome;
        
    }
    
    public function get_campoAssociativa(){
        
        return $this->campoAssociativa;
        
    }
    
    public function selecionar(){
        
        $this->db->select(implode(',', $this->campos));

        $this->db->from($this->get_tabela());
        
        if (!empty($this->criterios_and)){
            
            foreach ($this->criterios_and as $chave => $valor){
            
                $this->db->where($chave, $valor);

            }
                        
        }
        
        if (!empty($this->criterios_or)){
            
            foreach ($this->criterios_or as $chave => $valor){
            
                $this->db->or_where($chave, $valor);

            }
                        
        }
        
        if (!empty($this->criterios_in)){
            
            $this->db->where_in($this->key, $this->criterios_in);
       
        }
        
        if (!empty($this->criterios_not_in)){
            
            $this->db->where_not_in($this->key, $this->criterios_not_in);
       
        }
        
        if (!empty($this->order_by)){
            
            foreach ($this->order_by as $chave => $valor){
            
                $this->db->order_by($chave, $valor, FALSE);

            }
                        
        }
        
        return $this->db->get()->result();
        
    }
    
    public function selecionarLinha(){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        if (!empty($this->criterios_and)){
            
            foreach ($this->criterios_and as $chave => $valor){
            
                $this->db->where($chave, $valor);

            }
                        
        }
        
        if (!empty($this->criterios_in)){
            
            $this->db->where_in($this->key, $this->criterios_in);
       
        }
        
        if (!empty($this->criterios_not_in)){
            
            $this->db->where_not_in($this->key, $this->criterios_not_in);
       
        }
        
        if (!empty($this->criterios_or)){
            
            foreach ($this->criterios_or as $chave => $valor){
            
                $this->db->or_where($chave, $valor);

            }
                        
        }
        
        if (!empty($this->order_by)){
            
            foreach ($this->order_by as $chave => $valor){
            
                $this->db->order_by($chave, $valor, FALSE);

            }
                        
        }
        
        return $this->db->get()->row();
        
    }
    
    public function colecao(){
        
        $this->db->select('*');

        $this->db->from($this->get_tabela());
        
        if (!empty($this->criterios_and)){
            
            foreach ($this->criterios_and as $chave => $valor){
            
                $this->db->where($chave, $valor);

            }
                        
        }
        
        if (!empty($this->criterios_in)){
            
            $this->db->where_in($this->key, $this->criterios_in);
       
        }
        
        if (!empty($this->criterios_not_in)){
            
            $this->db->where_not_in($this->key, $this->criterios_not_in);
       
        }
        
        if (!empty($this->order_by)){
            
            foreach ($this->order_by as $chave => $valor){
            
                $this->db->order_by($chave, $valor, FALSE);

            }
                        
        }
        
        return $this->db->get()->result();
        
    }
    
    public function inserir(){
        
        foreach ($this->camposValores as $valor){
            
            if (preg_match('/[\#\$\*\+\=\}\{\]\[\|\>\<]+/', $valor)){

                return 'invalido';

            }
            
        }
        
        foreach ($this->camposValores as $campo => $valor){

            if (is_string($valor)){
                
                $this->camposValores[$campo] = "'$valor'";
                
            }elseif (is_null($valor)){
                
                $this->camposValores[$campo] = 'NULL';
                
            }
            
        }
        
        try{
            
            $this->db->insert($this->get_tabela(), $this->camposValores, FALSE);
            
            $codigo = $this->db->conn_id->insert_id;
            
            return $codigo;
              
        }catch (Exception $ex) {
            
            return $ex->getMessage();

        }
        
    }
        
    public function atualizar($codigo = NULL){
        
        foreach ($this->camposValores as $valor){
            
            if (preg_match('/[\$\+\}\{\]\[\|\>\<]+/', $valor)){

                return 'invalido';

            }
            
        }
        
        $sql = 'UPDATE '.$this->tabela.' SET ';
        
        $qtd = count($this->camposValores);
        $i = 0;

        foreach ($this->camposValores as $campo => $valor){

            if (is_string($valor)){
                
                $sql .= $campo.' = '."'$valor'";
                
            }elseif (is_null($valor)){
                
                $sql .= $campo.' = '.'NULL';
                
            }else{
                
                $sql .= $campo.' = '.$valor;
                
            }
            
            if(++$i !== $qtd) {$sql .= ",";}

        }
        
        if (!empty($this->criterios_and) && $codigo == NULL){
            
            $qtd = count($this->criterios_and);
            $i = 0;
            
            foreach ($this->criterios_and as $chave => $valor){
                
                if ($i > 0){
                
                    if (is_string($valor)){

                        $sql .= ' AND '.$chave.' = '."'$valor'";

                    }else{

                        $sql .= ' AND '.$chave.' = '.$valor;

                    }
                
                }else{
                
                    if (is_string($valor)){

                        $sql .= ' WHERE '.$chave.' = '."'$valor'";

                    }else{

                        $sql .= ' WHERE '.$chave.' = '.$valor;

                    }
                
                }
                
                $i++;
            
            }
                        
        }else{
            
            $sql .= ' WHERE '.$this->chavePrimaria.' = '.$codigo;
            
        }
           
        try{
            
            $this->db->query($sql);
            
            return TRUE;

        }catch (Exception $ex) {

            return $ex->getMessage();

        }
        
    }
    
    public function excluir(){
        
        $sql = 'DELETE FROM '.$this->get_tabela()." ";
        
        $i = 0;
        
        if (!empty($this->criterios_and)){
        
            foreach ($this->criterios_and as $chave => $valor){

                if ($i > 0){

                    $sql .= " AND $chave = $valor";

                }else{

                    $sql .= " WHERE $chave = $valor";

                }

                $i++;

            }
        
        }
        
        if (!empty($this->criterios_in)){
            
            $sql .= " WHERE $this->key IN (".implode(',', $this->criterios_in).")";
       
        }
            
        try{
            
            $this->db->query($sql);
            
            return TRUE;

        }catch (Exception $ex) {

            return $ex->getMessage();

        }
        
    }
    
    public function apagar($codigo = null){
        
        $sql = 'DELETE FROM '.$this->get_tabela();
        
        if ($codigo){
            
            $sql .= ' WHERE '.$this->get_chavePrimaria().' = '.$codigo;
            
        }
        
        try{
            
            $this->db->query($sql);
            
            return TRUE;

        }catch (Exception $ex) {

            return $ex->getMessage();

        }
        
    }
    
    public function apagarAssociativa($codigo){
        
        $sql = 'DELETE FROM '.$this->get_tabela();
        
        $sql .= ' WHERE '.$this->campoAssociativa.' = '.$codigo;
        
        try{
            
            $this->db->query($sql);
            
            return TRUE;

        }catch (Exception $ex) {

            return $ex->getMessage();

        }
        
    }
    
    public function codigoInsercao(){
        
        $this->db->select(implode(',', $this->campos));

        $this->db->from($this->get_tabela());
        
        return $this->db->get()->row();
        
    }
    
    public function selecionaAnosValidacao($contratoCodigo){
        
        $this->db->select('DISTINCT ANO', FALSE);

        $this->db->from($this->tabela);
        
        $this->db->where('CONTRATO_CODIGO', $contratoCodigo);
        
        $this->db->where('ANO <= '.date('Y'));
        
        $this->db->order_by('ANO', 'DESC', FALSE);
        
        return $this->db->get()->result();
        
    }
    
    public function selecionaMesesAnoValidacao($contratoCodigo, $ano){
        
        $this->db->select('MES', FALSE);

        $this->db->from($this->tabela);
        
        $this->db->where('CONTRATO_CODIGO', $contratoCodigo);
        
        $this->db->where('ANO', $ano);
        
        if ($ano == date('Y')){ // Ano igual ao ano atual
            
            $this->db->where('MES <= '.date('n'));
            
        }
        
        $this->db->order_by('MES', 'ASC', FALSE);
        
        return $this->db->get()->result();
        
    }
    
    public function selecionaMesesValidacao($contratoCodigo, $ano, $mes = null, $validado = null){
        
        $this->db->select('MES', FALSE);
        $this->db->from($this->tabela);
        $this->db->where('CONTRATO_CODIGO', $contratoCodigo);
        $this->db->where('ANO', $ano);

        if (!is_null($mes)){
            
            $this->db->where('MES <= '.$mes);
            
        }
        
        if (!is_null($validado)){
            
            $this->db->where('VALIDADO', $validado);
            
        }
        
        $this->db->order_by('MES', 'ASC');
        
        return $this->db->get()->result();
        
    }
    
    public function selecionaValidacoesAcompanhamento($contratoCodigo, $ano, $mes = null){
        
        $this->db->select('*');
        $this->db->from($this->get_tabela());
        $this->db->where('CONTRATO_CODIGO', $contratoCodigo);
        $this->db->where('ANO', $ano);
        
        if (!is_null($mes)){
            
            $this->db->where('MES <= '.$mes);
            
        }
        
        return $this->db->get()->result();
        
    }
    
    public function selecionaValidacoesMesAcompanhamento($contratoCodigo, $ano, $mes){
        
        $this->db->select('*');
        $this->db->from($this->get_tabela());
        $this->db->where('CONTRATO_CODIGO', $contratoCodigo);
        $this->db->where('ANO', $ano);
        $this->db->where('MES', $mes);
          
        return $this->db->get()->result();
        
    }
    
    public function verificaCampoValor($campo, $valor){
        
        $this->db->select("$campo");

        $this->db->from($this->get_tabela());
        
        $this->db->where("$campo", $valor);
        
        if (empty($this->db->get()->result())){
            
            return FALSE;
            
        }else{
            
            return TRUE;
            
        }
        
    }
    
}
