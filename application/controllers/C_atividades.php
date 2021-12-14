<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_atividades extends S_Controller {
    
    private $usuarioCodigo;
    private $perfilCodigos;
    private $resultado = TRUE;
        
    function __construct(){
        
        parent::__construct();
        
        if(!$this->session->userdata('logado')){
            
            redirect('c_principal','refresh'); // Caso o usuario nao esteja logado, redireciona para a tela de login

        }
        
        $this->usuarioCodigo = $this->session->userdata('usuarioCodigo');
        
        $this->perfilCodigos = $this->session->userdata('perfilCodigos');
        
        if (!(in_array(M_Constantes::Administrador, $this->perfilCodigos)) &&
            !(in_array(M_constantes::Usuario, $this->perfilCodigos))){
            
            $this->m_log->gravaLog(utf8_encode("Tentativa de acesso indevido ao sistema"), $this->usuarioCodigo);
            
            redirect('negado','refresh'); // Caso o usuario nao possua o perfil adequado, redireciona para a tela de acesso negado
        
        }
        
        $this->load->model('entidades/m_atividades');
        $this->load->model('entidades/m_tipo_atividade');
        
    }
    
    public function index(){
        
        $atividades = new M_atividades();
        
        $tiposAtividades = new M_tipo_atividade();
        
        $linhas = "";
        
        foreach ($atividades->selecionaAtividades() as $atividade){
            
            $concluir = "<button onclick='concluir($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-check-circle'></i> Concluir</button>";
            
            $salvar = "<button onclick='salvar($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-save'></i> Salvar</button>";
            
            if ($atividade->TIPO_CODIGO == M_Constantes::ManutencaoUrgente){
                    
                $excluir = "";

            }else{

                $excluir = "<button id='excluir$atividade->CODIGO' onclick='excluir($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-trash'></i> Excluir</button>";

            }
            
            $tipoAtividadeCombo = "<select style='width:100%;' id='tipo$atividade->CODIGO'>";
            
            foreach ($tiposAtividades->colecao() as $tipoAtividade){
                
                if ($atividade->TIPO_CODIGO == $tipoAtividade->CODIGO){
                    
                    $tipoAtividadeCombo .= "<option value='$tipoAtividade->CODIGO' selected>".utf8_decode($tipoAtividade->DESCRICAO)."</option>";
                    
                }else{
                    
                    $tipoAtividadeCombo .= "<option value='$tipoAtividade->CODIGO'>".utf8_decode($tipoAtividade->DESCRICAO)."</option>";
                    
                }
                
            }
            
            $tipoAtividadeCombo .= "</select>";
            
            $linhas .= "<tr id='linha$atividade->CODIGO'>
                        
                            <td style='width:15%;'><input size='20' requerido='true' type='text' style='width:100%;' id='titulo$atividade->CODIGO' value='".utf8_decode($atividade->TITULO)."'></td>

                            <td style='width:45%;'><input size='30' type='text' requerido='true' style='width:100%;' id='descricao$atividade->CODIGO' value='".utf8_decode($atividade->DESCRICAO)."'></td>

                            <td style='width:15%;'>
                            
                                <input type='hidden' id='tipoOriginal$atividade->CODIGO' value='$atividade->TIPO_CODIGO'>

                                $tipoAtividadeCombo
                                
                            </td>

                            <td style='width:25%;'><div align='center'>$concluir $salvar <span id='botaoExcluir$atividade->CODIGO'>$excluir</span></div></td>

                        </tr>";
            
        }
                
        $this->atribuirDados('pagina_titulo', 'Atividades');
        $this->atribuirDados('linhas', $linhas);
        $this->atribuirDados('tipoMntUrgente', M_Constantes::ManutencaoUrgente);
        $this->atribuirDados('tipoAtendimento', M_Constantes::Atendimento);
        $this->template->show('atividades/v_atividades', $this->recuperarDados());
        
    }
    
    public function filtrar(){
        
        $status = $this->input->post('status');
        
        $atividades = new M_atividades();
        
        $tiposAtividades = new M_tipo_atividade();
        
        $linhas = "";
        
        foreach ($atividades->selecionaAtividades($status) as $atividade){
            
            if ($status == M_Constantes::Aberta){ // Atividades abertas
                    
                $concluir = "<button onclick='concluir($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-check-circle'></i> Concluir</button>";
                
                $salvar = "<button onclick='salvar($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-save'></i> Salvar</button>";
                
                if ($atividade->TIPO_CODIGO == M_Constantes::ManutencaoUrgente){
                    
                    $excluir = "";

                }else{

                    $excluir = "<button id='excluir$atividade->CODIGO' onclick='excluir($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-trash'></i> Excluir</button>";

                }

                $tipoAtividadeCombo = "<select style='width:100%;' id='tipo$atividade->CODIGO'>";

                foreach ($tiposAtividades->colecao() as $tipoAtividade){

                    if ($atividade->TIPO_CODIGO == $tipoAtividade->CODIGO){

                        $tipoAtividadeCombo .= "<option value='$tipoAtividade->CODIGO' selected>".utf8_decode($tipoAtividade->DESCRICAO)."</option>";

                    }else{

                        $tipoAtividadeCombo .= "<option value='$tipoAtividade->CODIGO'>".utf8_decode($tipoAtividade->DESCRICAO)."</option>";

                    }

                }

                $tipoAtividadeCombo .= "</select>";

                $linhas .= "<tr id='linha$atividade->CODIGO'>

                                <td style='width:15%;'><input size='20' requerido='true' type='text' style='width:100%;' id='titulo$atividade->CODIGO' value='".utf8_decode($atividade->TITULO)."'></td>

                                <td style='width:45%;'><input size='30' type='text' requerido='true' style='width:100%;' id='descricao$atividade->CODIGO' value='".utf8_decode($atividade->DESCRICAO)."'></td>

                                <td style='width:15%;'>

                                    <input type='hidden' id='tipoOriginal$atividade->CODIGO' value='$atividade->TIPO_CODIGO'>

                                    $tipoAtividadeCombo

                                </td>

                                <td style='width:25%;'><div align='center'>$concluir $salvar <span id='botaoExcluir$atividade->CODIGO'>$excluir</span></div></td>

                            </tr>";
                
            }else{ // Atividades concluidas

                $reabrir = "<button onclick='reabrir($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-check-circle'></i> Reabrir</button>";
                
                if ($atividade->TIPO_CODIGO == M_Constantes::ManutencaoUrgente){
                    
                    $excluir = "";

                }else{

                    $excluir = "<button id='excluir$atividade->CODIGO' onclick='excluir($atividade->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-trash'></i> Excluir</button>";

                }
                
                $tiposAtividades = new M_tipo_atividade($atividade->TIPO_CODIGO);
                
                $linhas .= "<tr id='linha$atividade->CODIGO'>

                                <td style='width:15%;'><span style='width:100%;' id='titulo$atividade->CODIGO'>".utf8_decode($atividade->TITULO)."</span></td>
                                    
                                <td style='width:45%;'><span style='width:100%;' id='descricao$atividade->CODIGO'>".utf8_decode($atividade->DESCRICAO)."</span></td>

                                <td style='width:15%;'><input type='hidden' id='tipo$atividade->CODIGO' value='$atividade->TIPO_CODIGO'>".utf8_decode($tiposAtividades->get_campos()->DESCRICAO)."</td>

                                <td style='width:25%;'><div align='center'>$reabrir $excluir</div></td>

                            </tr>";

            }
            
        }
                
        $this->atribuirDados('linhas', $linhas);
        $this->atribuirDados('tipoMntUrgente', M_Constantes::ManutencaoUrgente);
        $this->load->view('atividades/v_atividades_filtrado', $this->recuperarDados());
        
    }
    
    public function imprimir(){
        
        $status = $this->input->post('status');
        
        $atividades = new M_atividades();
        
        $linhas = "";
        
        foreach ($atividades->selecionaAtividadesImpressao($status) as $atividade){
            
            $linhas .= "<tr>
                        
                            <td style='width:15%;' class='texto'>".utf8_decode($atividade->TITULO)."</td>

                            <td style='width:45%;' class='texto'>".utf8_decode($atividade->DESCRICAO)."</td>

                            <td style='width:15%;' class='texto'>".utf8_decode($atividade->TIPO)."</td>

                        </tr>";
            
        }
        
        if ($status == M_Constantes::Aberta){
                
            $this->atribuirDados('status', "NÃO CONCLUÍDAS");

        }else{

            $this->atribuirDados('status', "CONCLUÍDAS");

        }
                
        $this->atribuirDados('linhas', $linhas);
        
        $dados_impressao = $this->load->view('atividades/v_atividades_imprimir', $this->recuperarDados(), TRUE);
        
        $nomeArquivo = 'Atividades';
        
        $this->visualizarImpressao(utf8_encode($dados_impressao), $nomeArquivo, 'P', 'mpdf');
        
    }
    
    public function novaAtividade(){
        
        $tiposAtividades = new M_tipo_atividade();
        
        $tipoAtividadeCombo = "<select style='width:50%;' id='n_tipo' name='n_tipo'>";
            
        foreach ($tiposAtividades->colecao() as $tipoAtividade){

            $tipoAtividadeCombo .= "<option value='$tipoAtividade->CODIGO'>".utf8_decode($tipoAtividade->DESCRICAO)."</option>";

        }
        
        $tipoAtividadeCombo .= "</select><br><br>";
        
        $this->atribuirDados('tipoAtividadeCombo', $tipoAtividadeCombo);
        
        $this->load->view('atividades/v_nova_atividade', $this->recuperarDados());
        
    }
    
    public function salvarNovaAtividade(){
        
        $titulo = $this->input->post('titulo');
        $descricao = $this->input->post('descricao');
        $tipo = $this->input->post('tipo');
        $tipoAtividade = $this->input->post('tipoAtividade');
        
        if ($tipo == M_Constantes::ManutencaoUrgente){
        
            $finalSemana = array(0, 5, 6); // 0 -> Domingo, 5 -> Sexta-Feira e 6 -> Sábado

            $hoje = date('Y/m/d');

            $horaAtual = strtotime(date('H:i'));

            $dia = date('w', strtotime($hoje));

            /* Verifica se eh sexta-feira depois de 13:00 horas, sabado ou domingo.
             * Manutencao urgente so podera ser cadastrada de segunda-feira a quinta-feira, em qualquer horario, e na sexta-feira ate as 12:59 horas.
             */
            if (in_array($dia, $finalSemana) && $horaAtual > strtotime(M_Constantes::HoraLimite)){

                exit("Manuten&ccedil;&otilde;es urgentes  s&oacute; podem ser cadastradas de segunda-feira a quinta-feira, em qualquer hor&aacute;rio, e na sexta-feira at&eacute; &agrave;s 12:59 horas.");

            }
               
        }
                        
        $atividades = new M_atividades();
        
        $atividades->set_camposValores(array('TITULO'=>$titulo, 'DESCRICAO'=>$descricao, 'TIPO_CODIGO'=>$tipo));

        $this->db->trans_begin(); // Inicia transacao

        $atividadeCodigo = $atividades->inserir();

        if (is_numeric($atividadeCodigo)){
            
            $log = $this->m_log->gravaLog("Inseriu nova atividade (Titulo: $titulo, Descricao: $descricao, Tipo: $tipoAtividade)", $this->usuarioCodigo);

            if ($log != TRUE){

                $this->resultado = FALSE;

            }

        }else{

            $this->resultado = FALSE;

        }

        if ($this->resultado){

            $this->db->trans_commit();

            echo 'ok';

        }else{

            $this->db->trans_rollback();
            
            echo $atividadeCodigo;

        }
            
    }
    
    public function concluir(){
        
        $atividadeCodigo = $this->input->post('codigo');
        $titulo = $this->input->post('titulo');
                       
        $atividades = new M_atividades($atividadeCodigo);
        
        $atividades->set_camposValores(array('STATUS'=> M_Constantes::Concluida));

        $resultado = $atividades->atualizar($atividadeCodigo);

        if ($resultado === TRUE){

            $this->m_log->gravaLog("Concluiu a atividade (Titulo: $titulo)", $this->usuarioCodigo);

            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
    public function reabrir(){
        
        $atividadeCodigo = $this->input->post('codigo');
        $titulo = $this->input->post('titulo');
        $tipo = $this->input->post('tipo');
                
        if ($tipo == M_Constantes::ManutencaoUrgente){
        
            $finalSemana = array(0, 5, 6); // 0 -> Domingo, 5 -> Sexta-Feira e 6 -> Sábado

            $hoje = date('Y/m/d');

            $horaAtual = strtotime(date('H:i'));

            $dia = date('w', strtotime($hoje));

            /* Verifica se eh sexta-feira depois de 13:00 horas, sabado ou domingo.
             * Manutencao urgente so podera ser cadastrada de segunda-feira a quinta-feira, em qualquer horario, e na sexta-feira ate as 12:59 horas.
             */
            if (in_array($dia, $finalSemana) && $horaAtual > strtotime(M_Constantes::HoraLimite)){

                exit("Manuten&ccedil;&otilde;es urgentes  s&oacute; podem ser cadastradas de segunda-feira a quinta-feira, em qualquer hor&aacute;rio, e na sexta-feira at&eacute; &agrave;s 12:59 horas.");

            }
               
        }
                       
        $atividades = new M_atividades($atividadeCodigo);
        
        $atividades->set_camposValores(array('STATUS'=> M_Constantes::Aberta));

        $resultado = $atividades->atualizar($atividadeCodigo);

        if ($resultado === TRUE){

            $this->m_log->gravaLog("Reabriu a atividade (Titulo: $titulo)", $this->usuarioCodigo);

            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
    public function salvar(){
        
        $atividadeCodigo = $this->input->post('codigo');
        $titulo = $this->input->post('titulo');
        $descricao = $this->input->post('descricao');
        $tipo = $this->input->post('tipo');
        $tipoOriginal = $this->input->post('tipoOriginal');
        $tipoAtividade = $this->input->post('tipoAtividade');
        
        if ($tipo == M_Constantes::ManutencaoUrgente && $tipo != $tipoOriginal){
        
            $finalSemana = array(0, 5, 6); // 0 -> Domingo, 5 -> Sexta-Feira e 6 -> Sábado

            $hoje = date('Y/m/d');

            $horaAtual = strtotime(date('H:i'));

            $dia = date('w', strtotime($hoje));

            /* Verifica se eh sexta-feira depois de 13:00 horas, sabado ou domingo.
             * Manutencao urgente so podera ser cadastrada de segunda-feira a quinta-feira, em qualquer horario, e na sexta-feira ate as 12:59 horas.
             */
            if (in_array($dia, $finalSemana) && $horaAtual > strtotime(M_Constantes::HoraLimite)){

                exit("Manuten&ccedil;&otilde;es urgentes  s&oacute; podem ser cadastradas de segunda-feira a quinta-feira, em qualquer hor&aacute;rio, e na sexta-feira at&eacute; &agrave;s 12:59 horas.");

            }
               
        }
            
        $atividades = new M_atividades($atividadeCodigo);
        
        $atividades->set_camposValores(array('TITULO'=>$titulo, 'DESCRICAO'=>$descricao, 'TIPO_CODIGO'=>$tipo));

        $resultado = $atividades->atualizar($atividadeCodigo);

        if ($resultado === TRUE){

            $this->m_log->gravaLog("Alterou a atividade (Titulo: $titulo, Descricao: $descricao, Tipo: $tipoAtividade)", $this->usuarioCodigo);

            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
    public function excluir(){
        
        $atividadeCodigo = $this->input->post('codigo');
        $titulo = $this->input->post('titulo');
                       
        $atividades = new M_atividades();
        
        $resultado = $atividades->apagar($atividadeCodigo);

        if ($resultado === TRUE){
            
            $this->m_log->gravaLog("Excluiu a Atividade $titulo", $this->usuarioCodigo);

            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
        
}