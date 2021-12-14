<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_usuarios extends S_Controller {
    
    private $usuarioCodigo;
    private $perfilCodigos;
    private $resultado = TRUE;
    
    function __construct(){
        
        parent::__construct();
        
        if(!$this->session->userdata('logado')){

            redirect('c_principal','refresh'); 

        }
        
        $this->perfilCodigos = $this->session->userdata('perfilCodigos');
        
        $this->usuarioCodigo = $this->session->userdata('usuarioCodigo');
        
        if (!(in_array(M_Constantes::Administrador, $this->perfilCodigos))){
            
            $this->m_log->gravaLog(utf8_encode("Tentativa de acesso indevido ao sistema"), $this->usuarioCodigo);
            
            redirect('negado','refresh');
        
        }
        
        $this->load->model('entidades/m_usuarios');
        $this->load->model('entidades/m_usuario');
        
    }
    
    public function index(){
        
        $this->load->model('entidades/m_perfil');
        $this->load->model('entidades/m_usuario_perfil');
                
        $usuarios = new M_usuarios();
        
        $linhas = "";
        
        foreach ($usuarios->colecao() as $usuario){
            
            $usuariosPerfis = new M_usuario($usuario->CODIGO);
            
            $perfilCodigos = $usuariosPerfis->get_perfilCodigos();
            
            $usuarioPerfis = array();
        
            if (empty($perfilCodigos)){ // Verifica se o usuário está sem perfil

                $usuarioPerfis[] = 'Usuário sem Perfil atribuído';

            }else{

                $perfis = $this->m_usuario_perfil->perfis($usuario->CODIGO);

                foreach($perfis as $perfil) {

                    $usuarioPerfis[] = utf8_decode($perfil->NOME);

                }

            }
            
            
            
            $perfis = "<button title='Perfis do Usuário: ".implode(', ', $usuarioPerfis)."' onclick='perfisUsuario($usuario->CODIGO)' type='button' class='ui-state-default ui-corner-all'><i class='fa fa-users'></i> Perfis</button>";
        
            $salvar = "<button onclick='salvar($usuario->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-save'></i> Salvar</button>";

            $resetaSenha = "<button title='Reseta a senha' onclick='resetaSenha($usuario->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-refresh'></i> Reset</button>";

            if ($usuario->ATIVO){

                $desativar = "<button onclick='inativar($usuario->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-power-off'></i> Inativar</button>";

            }else{

                $desativar = "<button onclick='ativar($usuario->CODIGO)' class='ui-state-default ui-corner-all'><i class='fa fa-power-off'></i>&nbsp;&nbsp;Ativar&nbsp;&nbsp;</button>";

            }
            
            $linhas .= "<tr id='linha$usuario->CODIGO'>
                    
                        <input size='20' type='hidden' id='loginOrig$usuario->CODIGO' value='$usuario->LOGIN'>
                                    
                            <td style='width:10%;'>

                                <input size='20' maxlength='14' requerido='true' type='text' style='width:100%;' id='login$usuario->CODIGO' value='$usuario->LOGIN'>

                            </td>

                            <td style='width:10%;'>

                                <input size='30' type='text' requerido='true' style='width:100%;' id='nome$usuario->CODIGO' value='".utf8_decode($usuario->NOME)."'>

                            </td>

                            <td style='width:18%;'>

                                <input size='60' type='text' placeholder='Contatos do Usuário' style='width:100%;' id='contato$usuario->CODIGO' value='".utf8_decode($usuario->CONTATO)."'>

                            </td>

                            <td style='width:18%;'>

                                <input size='60' type='text' placeholder='E-mail do Usuário' style='width:100%;' id='email$usuario->CODIGO' value='$usuario->EMAIL'>

                            </td>


                            <td style='width:25%;'><div align='center'>$salvar $perfis $resetaSenha<span id='botoes$usuario->CODIGO'>$desativar</span></div></td>

                        </tr>";
            
        }
                
        $this->atribuirDados('linhas', $linhas);
        $this->atribuirDados('pagina_titulo', 'Usuários do Sistema');
        $this->template->show('administracao/v_usuarios', $this->recuperarDados());
        
    }
    
    public function novoUsuario(){
        
        $this->load->view('administracao/v_novo_usuario', $this->recuperarDados());
        
    }
    
    public function salvarNovoUsuario(){
        
        $this->load->model('entidades/m_usuario_perfil');
        
        $login = str_replace('.', '', str_replace('-', '', $this->input->post('login')));
        $nome = $this->input->post('nome');
        $contato = $this->input->post('contato');
        $email = $this->input->post('email');
                
        if (!preg_match('/^[0-9]+$/u', $login)){
            
            exit('invalido');
            
        }
        
        $usuario = new M_usuarios();
        $usuario->set_criterios_and(array('LOGIN'=>$login));
        
        $linha = $usuario->selecionarLinha();
        
        if (empty($linha)){
            
            $usuario->set_camposValores(array('LOGIN'=>$login, 'NOME'=>$nome, 'CONTATO'=>$contato, 'EMAIL'=>$email));
            
            $this->db->trans_begin(); // Inicia transacao

            $usuarioCodigo = $usuario->inserir();

            if (is_numeric($usuarioCodigo)){
                
                $senha = password_hash($login, PASSWORD_DEFAULT);
            
                $usuario->atualizarSenha($usuarioCodigo, $senha);
                
                $usuarioPerfil = new M_usuario_perfil();
                
                $usuarioPerfil->set_camposValores(array('USUARIO_CODIGO'=>$usuarioCodigo, 'PERFIL_CODIGO'=> M_Constantes::Usuario));
                
                $salvaPerfil = $usuarioPerfil->inserir();
                
                if (!is_numeric($salvaPerfil)){

                    $this->resultado = FALSE;

                }
                
                $log = $this->m_log->gravaLog(utf8_encode("Inseriu novo usuário ")."Login: $login, Nome: $nome", $this->usuarioCodigo);
                
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

            }
            
        }else{
            
            echo 'existe';
            
        }
        
    }
    
    public function salvar(){
        
        $usuarioCodigo = $this->input->post('codigo');
        $login = str_replace('.', '', str_replace('-', '', $this->input->post('login')));
        $loginOrig = $this->input->post('loginOrig');
        $nome = $this->input->post('nome');
        $contato = $this->input->post('contato');
        $email = $this->input->post('email');
               
        if (!preg_match('/^[0-9]+$/u', $login)){
            
            exit('invalido');
            
        }
        
        $usuario = new M_usuario($usuarioCodigo);
        
        if ($login !== $loginOrig){
        
            $usuario->set_criterios_and(array('LOGIN'=>$login));

            $linha = $usuario->selecionarLinha();

            if (empty($linha)){
                
                $usuario->set_camposValores(array('LOGIN'=>$login, 'NOME'=>$nome, 'CONTATO'=>$contato, 'EMAIL'=>$email));

                $resultado = $usuario->atualizar($usuarioCodigo);

                if ($resultado === TRUE){
                    
                    $this->m_log->gravaLog(utf8_encode("Alterou dados do usuário ")."login: $login, Nome: $nome, contato: $contato, e-mail: $email", $this->usuarioCodigo);

                    echo 'ok';

                }else{

                    echo $resultado;

                }

            }else{

                echo 'existe';

            }
            
        }else{
            
            $usuario->set_camposValores(array('LOGIN'=>$login, 'NOME'=>$nome, 'CONTATO'=>$contato, 'EMAIL'=>$email));

            $resultado = $usuario->atualizar($usuarioCodigo);

            if ($resultado === TRUE){
                
                $this->m_log->gravaLog(utf8_encode("Alterou dados do usuário ")."login: $login, Nome: $nome, contato: $contato, e-mail: $email", $this->usuarioCodigo);

                echo 'ok';

            }else{

                echo $resultado;

            }
            
        }
        
    }
    
    public function perfisUsuario(){
        
        $this->load->model('entidades/m_perfil');
        
        $usuarioCodigo = $this->input->post('codigo');
        
        $perfis_disponiveis = '';
        
        $perfis_selecionados = '';
        
        $usuario = new M_usuario($usuarioCodigo);
        
        $perfisAtribuidos = $usuario->get_perfilCodigos();
        
        if (empty($perfisAtribuidos)){ // Verifica se o usuário está sem perfil
            
            $perfisAtribuidos[] = M_constantes::SemPerfil;
            
        }
        
        $perfis = new M_perfil();
        
        $perfis->set_campos(array('*'));
        
        $perfis->set_order_by(array('NOME'=>'ASC'));
        
        $perfisDisponiveis = $perfis->selecionar();
        
        $largura = '340px';
        
        foreach ($perfisDisponiveis as $perfilDisponivel){
            
            if (!in_array($perfilDisponivel->CODIGO, $perfisAtribuidos)){
                
                $perfis_disponiveis .= '<li style="width:'.$largura.';" class="alert alert-primary" id="'.$perfilDisponivel->CODIGO.'" onClick="atribui('.$perfilDisponivel->CODIGO.')">'.utf8_decode($perfilDisponivel->NOME).'</li>';

            }
            
        }
        
        $perfis->set_criterios_in('CODIGO', $perfisAtribuidos); // Seta os criterios com os codigos dos perfis atribuidos
        
        foreach ($perfis->selecionar() as $perfilUsuario){
            
            if ($perfilUsuario->CODIGO == M_Constantes::Usuario){ // Perfil Usuario nao pode ser desatrinuido
                
                $perfis_selecionados .= '<li style="width:'.$largura.';" class="alert alert-primary" id="'.$perfilUsuario->CODIGO.'" disabled>'.utf8_decode($perfilUsuario->NOME).'</li>';
                
            }else{
                
                $perfis_selecionados .= '<li style="width:'.$largura.';" class="alert alert-primary" id="'.$perfilUsuario->CODIGO.'" onClick="desatribui('.$perfilUsuario->CODIGO.')">'.utf8_decode($perfilUsuario->NOME).'</li>';
                
            }
            
        }
       
        $this->atribuirDados('perfis_disponiveis', $perfis_disponiveis);
        $this->atribuirDados('perfis_selecionados', $perfis_selecionados);
        
        $this->load->view('administracao/v_perfis_usuario', $this->recuperarDados());
        
    }
    
    public function dataFimPerfil(){
        
        $this->atribuirDados('id', $this->input->post('id'));

        $this->load->view('administracao/v_data_perfil', $this->recuperarDados());
    }
    
    public function salvarPerfisAtribuidos(){
        
        $this->load->model('entidades/m_usuario');
        $this->load->model('entidades/m_usuario_perfil');
        
        $usuarioCodigo = $this->input->post('codigo');
        $id_atribuidos = $this->input->post('id_atribuidos');
        $usuarioPerfil = new M_usuario_perfil();
        
        $usuarioPerfil->set_campoAssociativa('USUARIO_CODIGO');
        
        $usuarioPerfil->apagarAssociativa($usuarioCodigo);
        
        foreach ($id_atribuidos as $valor){
            
            $usuarioPerfil->set_camposValores(array('USUARIO_CODIGO'=>$usuarioCodigo, 'PERFIL_CODIGO'=>$valor));
              
            $resultado = $usuarioPerfil->inserir();
            
            if (is_numeric($resultado)){
                
                $inserir = $resultado;

            }else{

                $inserir = 'erro';

            }
            
        }
        
        $usuario = new M_usuario($usuarioCodigo);
                
        $nome = $usuario->get_campos()->NOME.' ('.$usuario->get_campos()->LOGIN.')';

        $codigoPerfis = implode(',', $id_atribuidos);

        $this->m_log->gravaLog(utf8_encode("Alterou os perfis do Usuário ")."$nome, para ($codigoPerfis)", $this->usuarioCodigo);
        
        echo $inserir;
       
    }
    
    public function resetarSenha(){
        
        $usuarioCodigo = $this->input->post('codigo');
        
        $usuario = new M_usuario($usuarioCodigo);
        
        $login = $usuario->get_campos()->LOGIN;
        
        $senha = password_hash($login, PASSWORD_DEFAULT);
            
        $resultado = $usuario->atualizarSenha($usuarioCodigo, $senha);
        
        if ($resultado){
            
            $nome = $usuario->get_campos()->NOME.' ('.$usuario->get_campos()->LOGIN.')';
            
            $this->m_log->gravaLog(utf8_encode("Resetou a senha do usuário ")."$nome", $this->usuarioCodigo);
                
            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
    public function inativar(){
        
        $usuarioCodigo = $this->input->post('codigo');
        
        $usuario = new M_usuario($usuarioCodigo);
        
        $usuario->set_camposValores(array('ATIVO' => 0));
        
        $resultado = $usuario->atualizar($usuarioCodigo);
        
        if ($resultado){
            
            $nome = $usuario->get_campos()->NOME.' ('.$usuario->get_campos()->LOGIN.')';
            
            $this->m_log->gravaLog(utf8_encode("Inativou o usuário ").$nome, $this->usuarioCodigo);
                
            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
    public function ativar(){
        
        $usuarioCodigo = $this->input->post('codigo');
        
        $usuario = new M_usuario($usuarioCodigo);
        
        $usuario->set_camposValores(array('ATIVO' => 1));
        
        $resultado = $usuario->atualizar($usuarioCodigo);
        
        if ($resultado){
            
            $nome = $usuario->get_campos()->NOME.' ('.$usuario->get_campos()->LOGIN.')';
            
            $this->m_log->gravaLog(utf8_encode("Ativou o usuário ").$nome, $this->usuarioCodigo);
                
            echo 'ok';

        }else{

            echo $resultado;

        }
        
    }
    
}