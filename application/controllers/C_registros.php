<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_registros extends S_Controller {
    
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
        
    }
    
    public function index(){
        
        $logs = new M_Log();
        
        $ano = date('Y');
        
        $anoCombo = '';
        
        $anosLog = $logs->selecionaAnosLog();

        if (empty($anosLog)){

            $anoCombo .= '<option value="'.$ano.'">'.$ano.'</option>';

        }else{
            
            $contador = 0;

            foreach ($anosLog as $anoLog){

                $anoCombo .= '<option value="'.$anoLog->ANO.'">'.$anoLog->ANO.'</option>';
                
                if ($contador == 0){

                    $ano = $anoLog->ANO;

                }

                $contador++;

            }

        }
        
        $usuarioCombo = '<option value="" selected>Responsável - Todos</option>';
            
        foreach ($logs->selecionaUsuarios($ano) as $usuario){
            
            $usuarioCombo .= '<option value="'.$usuario->CODIGO.'">'.utf8_decode($usuario->USUARIO).'</option>';
                
        }
        
        $dataIni = date('d/m/Y', strtotime('-20 days', strtotime(date('Y-m-d')))); // Hoje - 20 dias
        
        $dataFim = date('d/m/Y'); // Hoje
        
        $this->atribuirDados('dataIni', $dataIni);
        $this->atribuirDados('dataFim', $dataFim);
        $this->atribuirDados('anoCombo', $anoCombo);
        $this->atribuirDados('usuarioCombo', $usuarioCombo);
        $this->atribuirDados('pagina_titulo', 'Registros do Sistema');
        $this->template->show('log/v_registros', $this->recuperarDados());
        
    }
    
    public function preencheCombos() {
        
        $ano = $this->input->post('ano');
        
        $logs = new M_Log();
        
        $usuarioCombo = '';
            
        foreach ($logs->selecionaUsuarios($ano) as $usuario){
            
            $usuarioCombo .= '<option value="'.$usuario->CODIGO.'">'.utf8_decode($usuario->USUARIO).'</option>';
                
        }
                
        header('Content-Type: application/json');
        echo json_encode(array(utf8_encode($usuarioCombo)));
        
    }
    
    public function consultarLog(){
        
        $ano = $this->input->post('ano');
        $usuarioCodigo = $this->input->post('usuario');
        $dataIni = $this->input->post('data_ini');
        $dataFim = $this->input->post('data_fim');
        
        if ($dataIni == '' && $dataFim == ''){
            
            $dataIni = date('Y-m-d', strtotime('-20 days', strtotime(date('d-m-Y'))));
            
        }elseif ($dataIni == '' && $dataFim != ''){
            
            $dataFim = date('Y-m-d', strtotime(str_replace('/', '-', $dataFim)));
            $dataIni = date('Y-m-d', strtotime('-20 days', strtotime(str_replace('/', '-', $dataFim))));
            
        }elseif ($dataIni != '' && $dataFim == ''){
            
            $dataIni = date('Y-m-d', strtotime(str_replace('/', '-', $dataIni)));
            
        }else{
            
            $dataIni = date('Y-m-d', strtotime(str_replace('/', '-', $dataIni)));
            $dataFim = date('Y-m-d', strtotime(str_replace('/', '-', $dataFim)));
            
        }
        
        $logs = new M_Log();
        $logColecao = $logs->consultarLogFiltrado($ano, $usuarioCodigo, $dataIni, $dataFim);
        
        $linhas = "";
        
        foreach ($logColecao as $log){

            $data = $log->DATA_LOG;
            $dataLog = substr($data, 8, 2).'/'.substr($data, 5, 2).'/'.substr($data, 0, 4).' - '.substr($data, 11, 8); // dia/mês/ANO - H:m:s

            $acao = utf8_decode($log->ACAO);

            $usuario = utf8_decode($log->USUARIO.'<br>'.$log->LOGIN);

            $linhas .= "<tr class='registros' style='line-height: 20px;'>

                            <td align='center' style='width:10%;' class='texto'>

                                <span style='width:100%;'>$dataLog</span>

                            </td>

                            <td align='justify' style='width:35%;' class='texto'>

                                <span style='width:100%;'>$acao</span>

                            </td>

                            <td align='center' style='width:12%;' class='texto'>

                                <span style='width:100%;'>$usuario</span>

                            </td>

                        </tr>";

        }
            
        $this->atribuirDados('linhas', $linhas);
        $this->load->view('log/v_registros_filtrado', $this->recuperarDados());
        
    }
    
    public function imprimirLog(){
        
        $ano = $this->input->post('ano');
        $usuarioCodigo = $this->input->post('usuario');
        $dataIni = $this->input->post('data_ini');
        $dataFim = $this->input->post('data_fim');
        
        if ($dataIni == '' && $dataFim == ''){
            
            $dataIni = date('Y-m-d', strtotime('-20 days', strtotime(date('d-m-Y'))));
            
        }elseif ($dataIni == '' && $dataFim != ''){
            
            $dataFim = date('Y-m-d', strtotime(str_replace('/', '-', $dataFim)));
            $dataIni = date('Y-m-d', strtotime('-20 days', strtotime(str_replace('/', '-', $dataFim))));
            
        }elseif ($dataIni != '' && $dataFim == ''){
            
            $dataIni = date('Y-m-d', strtotime(str_replace('/', '-', $dataIni)));
            
        }else{
            
            $dataIni = date('Y-m-d', strtotime(str_replace('/', '-', $dataIni)));
            $dataFim = date('Y-m-d', strtotime(str_replace('/', '-', $dataFim)));
            
        }
        
        $logs = new M_Log();
        $logColecao = $logs->consultarLogFiltrado($ano, $usuarioCodigo, $dataIni, $dataFim);
        
        $linhas = "";
        
        foreach ($logColecao as $log){

            $data = $log->DATA_LOG;
            $dataLog = substr($data, 8, 2).'/'.substr($data, 5, 2).'/'.substr($data, 0, 4).' - '.substr($data, 11, 8); // dia/mês/ANO - H:m:s

            $acao = utf8_decode($log->ACAO);

            $usuario = utf8_decode($log->USUARIO.'<br>'.$log->LOGIN);

            $linhas .= "<tr class='registros' style='line-height: 20px;'>

                            <td align='center' style='width:10%;' class='texto'>

                                <span style='width:100%;'>$dataLog</span>

                            </td>

                            <td align='justify' style='width:35%;' class='texto'>

                                <span style='width:100%;'>$acao</span>

                            </td>

                            <td align='center' style='width:12%;' class='texto'>

                                <span style='width:100%;'>$usuario</span>

                            </td>

                        </tr>";

        }

        $this->atribuirDados('linhas', $linhas);
        
        $this->atribuirDados('usuario', $this->input->post('usuarioDesc'));
                           
        $dataIniRel = $this->input->post('data_ini');
        $dataFimRel = $this->input->post('data_fim');
        
        if ($dataIniRel == '' && $dataFimRel == ''){
            
            $this->atribuirDados('periodo', '');
            
        }elseif ($dataIniRel == '' && $dataFimRel != ''){
            
            $this->atribuirDados('periodo', 'até '.$dataFimRel);
            
        }elseif ($dataIniRel != '' && $dataFimRel == ''){
            
            $this->atribuirDados('periodo', 'de '.$dataIniRel.' até '.date('d/m/Y'));
            
        }else{
            
            $this->atribuirDados('periodo', 'de '.$dataIniRel.' até '.$dataFimRel);
            
        }
        
        $dados_impressao = $this->load->view('log/v_imprimir_registros', $this->recuperarDados(), TRUE);
        
        $nomeArquivo = 'consultaRegistros';
        
        $this->visualizarImpressao(utf8_encode($dados_impressao), $nomeArquivo, 'L', 'mpdf');
        
    }
    
}
