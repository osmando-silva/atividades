<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_login extends S_Controller {
    
    function __construct(){
        
        parent::__construct();
        
    }
    
    public function index(){
        
        $seq = rand(1000000,9999999); // Cria uma sequencia aleatoria com 7 caracteres
        
        $this->session->set_userdata('seq', $seq); // Seta a variavel de sessao com a sequencia criada
        
        $this->session->set_flashdata('logout', '1'); // Seta a variavel de sessao logout com 1
        
        /* Cria um array a ser passado para a view (tela) de login.
         * Os indices dos arrays serao transformados em variaveis na view de login, com os seus respectivos valores
         */
        $data['login'] = $this->session->userdata('login');
        $data['senha'] = '';
        $data['seq'] = $seq;
                
        $this->template->showLogin('login/v_login', $data); // Aciona a library Template, que carrega o topo, o meio e o rodape da pagina
        
    }
    
    /* Metodo chamado quando o usario aciona o botao entrar na tela de login
     * Faz toda a verificacao dos dados do usuario e habilita ou nao o acesso.
     */
    public function validate(){
        
        $this->load->model('entidades/m_usuario'); // Carrega o model de usuarios
        $this->load->library('Encryption'); // Carrega a biblioteca para decriptar o login e a senha
        
        $seq = $this->session->userdata('seq'); // Variavel de sessao com a sequencia aleatoria
        $codseguranca = $this->input->post('codseguranca'); // Variavel do POST com o codigo de seguranca (captcha)
        
        $encryption = new Encryption();
        
        $login = $encryption->decrypt($this->input->post('hashLogin'), $seq); // decripta o login
        
        $senha = $encryption->decrypt($this->input->post('hash'), $seq); // decripta a senha
        
        /* Verifica se o codigo de seguranca do POST eh igual ao da variavel de sessao.
         * Se forem diferentes, o usuario serah redirecionado para a tela de login.
         * O arquivo atividades.js trata esse codigo e mostra uma mensagem.
        */
        if ($codseguranca != $this->session->userdata('autenticacao')){
            
            $this->session->set_flashdata('codSeg',(bool)TRUE);
            $this->session->set_userdata('login', $login);
            redirect();
            
        }
        
        $dadosUsuario = $this->m_usuario->dadosUsuario($login);
        
        if (empty($dadosUsuario)){ // Testa se o usuario existe. 
            
            $this->session->set_flashdata('inexistente',(bool)TRUE);
            $this->session->set_userdata('login', $login);
            redirect(); // Redireciona para o controller default (config/routes.php)
            
        }elseif (!$dadosUsuario->ATIVO){ // Testa se o usuario esta ativo. 
            
            $this->session->set_flashdata('desativado',(bool)TRUE);
            $this->session->set_userdata('login', $login);
            redirect();
            
        }
        
        $usuario = new M_usuario($dadosUsuario->CODIGO);
        
        $hashDb = $usuario->get_campos()->SENHA;
        
        if (password_verify($senha, $hashDb)){
        
            if (password_verify($login, $hashDb)){ // Senha igual ao login (primeiro acesso)
                
                $this->session->set_flashdata('primeiroAcesso',(bool)TRUE);
                $this->session->set_userdata('login', $login);
                $this->session->unset_userdata('seq');
                redirect();

            }else{ // Login bem sucedido
        
                $this->session->set_userdata('login', $login);
                $this->session->set_userdata('usuarioCodigo', $dadosUsuario->CODIGO);
                $this->session->set_userdata('logado',(bool)TRUE);
                $this->session->unset_userdata('seq');
                
                $this->m_login->apagaRelatorios($dadosUsuario->CODIGO);
                $this->m_log->gravaLog('Efetuou Login', $dadosUsuario->CODIGO, $usuario->get_campos()->OM_CODIGO);
                redirect();

            }
            
        }else{
            
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('erroLogin', (bool)TRUE);
            redirect();

        }
            
    }

    public function logout(){
        
        $this->m_login->apagaRelatorios($this->session->userdata('usuarioCodigo'));
            
        if($this->session->userdata('logado')){
            
            $this->m_log->gravaLog('Efetuou Logout', $this->session->userdata('usuarioCodigo'));
    
        }
            
        $this->session->sess_destroy();
        
        redirect();
        
    }
    
    public function sair(){
        
        $this->m_login->apagaRelatorios($this->session->userdata('usuarioCodigo'));
            
        $this->m_log->gravaLog(utf8_encode('Sessão expirou'), $this->session->userdata('usuarioCodigo'));
    
        $this->session->sess_destroy();
        
        echo 'A sessão expirou.';
        
    }

}

