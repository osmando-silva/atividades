<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_tipo_atividade extends S_Controller {
    
    private $usuarioCodigo;
    private $perfilCodigos;
            
    function __construct(){
        
        parent::__construct();
        
        if(!$this->session->userdata('logado')){

            redirect('c_principal','refresh');

        }
        
        $this->usuarioCodigo = $this->session->userdata('usuarioCodigo');
        
        $this->perfilCodigos = $this->session->userdata('perfilCodigos');
        
        if (!(in_array(M_Constantes::Administrador, $this->perfilCodigos))){
            
            $this->m_log->gravaLog(utf8_encode("Tentativa de acesso indevido ao sistema"), $this->usuarioCodigo);
            
            redirect('negado','refresh');
        
        }
        
        $this->load->model('entidades/m_tipo_atividade');
                        
    }
    
    public function index(){
        
        $tipoAtividade = new M_tipo_atividade();
        
        $linhas = "";
        
        foreach ($tipoAtividade->colecao() as $tipo){
            
            $salvar = "<button onclick='salvar($tipo->CODIGO)' class='ui-state-default ui-corner-all'>Salvar</button>";
        
            $excluir = "<button onclick='excluir($tipo->CODIGO)' class='ui-state-default ui-corner-all'>Excluir</button>";
            
            $linhas .= "<tr id='linha$tipo->CODIGO'>
                                  
                            <td style='width:45%;'><input type='text' requerido='true' style='width:100%;' id='descricao$tipo->CODIGO' value='".utf8_decode($tipo->DESCRICAO)."'></td>

                            <td style='width:25%;'><div align='center'>$salvar $excluir</div></td>

                        </tr>";
            
        }
                
        $this->atribuirDados('linhas', $linhas);
        $this->atribuirDados('pagina_titulo', 'Tipos de Atividades');
        $this->template->show('administracao/v_tipo_atividade', $this->recuperarDados());
        
    }
    
    public function salvar(){
        
        $tipoAtividadeCodigo = $this->input->post('codigo');
        $descricao = $this->input->post('descricao');
        
        $tipoAtividade = new M_tipo_atividade();
        
        $tipoAtividade->set_camposValores(array('DESCRICAO'=>$descricao));

        $resultado = $tipoAtividade->atualizar($tipoAtividadeCodigo);

        if ($resultado === TRUE){
            
            $this->m_log->gravaLog(utf8_encode("Alterou o Tipo de Atividade Código: $tipoAtividadeCodigo, Descrição: ")."$descricao", $this->usuarioCodigo);

            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
    public function excluir(){
        
        $this->load->model("entidades/m_atividades");
        
        $tipoAtividadeCodigo = $this->input->post('codigo');
        $descricao = $this->input->post('descricao');
                       
        $tipoAtividade = new M_tipo_atividade();
        
        $atividades = new M_atividades();
        
        if ($atividades->verificaCampoValor("TIPO_CODIGO", $tipoAtividadeCodigo)){
            
            exit('usado');
            
        }
        
        $resultado = $tipoAtividade->apagar($tipoAtividadeCodigo);

        if ($resultado === TRUE){
            
            $this->m_log->gravaLog(utf8_encode("Excluiu o Tipo de Atividade Descrição: ")."$descricao", $this->usuarioCodigo);

            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
    public function novoTipo(){
        
        $this->load->view('administracao/v_novo_tipo_atividade');
        
    }
    
    public function salvarNovoTipo(){
        
        $descricao = $this->input->post('descricao');
               
        $tipoAtividade = new M_tipo_atividade();
        
        $tipoAtividade->set_camposValores(array('DESCRICAO'=>$descricao));

        $tipoAtividadeCodigo = $tipoAtividade->inserir();

        if (is_numeric($tipoAtividadeCodigo)){

            $this->m_log->gravaLog("Inseriu novo Tipo de Material $descricao", $this->usuarioCodigo);

            echo 'ok';

        }else{

            echo $tipoAtividadeCodigo;

        }
        
    }
    
}