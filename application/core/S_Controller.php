<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class S_Controller extends CI_Controller {
    
    private $dados;
    private $cor;
    private $tooltip;
    private $aVencer = FALSE;
    
    public function __construct() {
        
        parent::__construct();
        
    }
    
    public function atribuirDados($atributo,$valor){
        
        $this->dados[$atributo]=$valor;
        
    }
    
    public function recuperarDados(){
        
        return $this->dados;
        
    }
    
    public function visualizarImpressao($dados_impressao, $nomeArquivo, $orientacao, $css = null, $rodape = null, $cabecalho = null){
        
        $this->load->library('mpdf_library');
        
        $caminhoDoArquivo = 'relatorios/'.$nomeArquivo.'-'.$this->session->userdata('usuarioCodigo').'.pdf';
        
        if (!$rodape){
            
           $rodape = "Impresso por: ".utf8_encode($this->session->userdata('usuarioNome'))." - {DATE j/m/Y H:i} | | {PAGENO}/{nb}";
            
        }
        
        $this->mpdf_library->pdf($dados_impressao, $caminhoDoArquivo, $orientacao, $css, $rodape, $cabecalho);
        
        $this->visualizarRelatorio($caminhoDoArquivo);
        
    }
        
    public function visualizarRelatorio($caminhoDoArquivo){
    
        $filename['filename'] = $caminhoDoArquivo;
        
        header('Content-Type: application/pdf');
        $this->load->view('impressao/v_visualizar_impressao',$filename);
    
    }
    
}

