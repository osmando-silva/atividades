<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class C_principal extends S_Controller {
    
    function __construct(){
        
        parent::__construct();
        
        if($this->session->flashdata('codSeg')){
            
            $this->session->set_flashdata('erroLogin', '5');
            redirect('entrar'); 
    
        }
        
        if($this->session->flashdata('inexistente')){
            
            $this->session->set_flashdata('erroLogin', '4');
            redirect('entrar'); 
    
        }
        
        if($this->session->flashdata('desativado')){
            
            $this->session->set_flashdata('erroLogin', '3');
            redirect('entrar'); 
    
        }
        
        if($this->session->flashdata('erroLogin')){
            
            $this->session->set_flashdata('erroLogin', '1');
            redirect('entrar'); 
    
        }
        
        if($this->session->flashdata('primeiroAcesso')){
            
            $this->session->set_flashdata('erroSenha', '4');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha'); 
            
        }
        
        if($this->session->flashdata('senhasNaoConferem')){
            
            $this->session->set_flashdata('erroSenha', '1');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha'); 
    
        }elseif ($this->session->flashdata('senhaCurta')) {
            
            $this->session->set_flashdata('erroSenha', '6');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha');
            
        }elseif ($this->session->flashdata('maiuscula')) {
            
            $this->session->set_flashdata('erroSenha', '7');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha');
            
        }elseif ($this->session->flashdata('minuscula')) {
            
            $this->session->set_flashdata('erroSenha', '8');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha');
            
        }elseif ($this->session->flashdata('numero')) {
            
            $this->session->set_flashdata('erroSenha', '9');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha');
            
        }elseif ($this->session->flashdata('espaco')) {
            
            $this->session->set_flashdata('erroSenha', '10');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha');
            
        }elseif ($this->session->flashdata('senhaVazia')) {
            
            $this->session->set_flashdata('erroSenha', '2');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha');
            
        }elseif ($this->session->flashdata('senhaIgualLogin')) {
            
            $this->session->set_flashdata('erroSenha', '3');
            $this->session->set_flashdata('alterarSenha',(bool)TRUE);
            redirect('senha');
            
        }
        
        if(!$this->session->userdata('logado')){
            
            redirect('entrar'); 
    
        }
          
    }
    
    public function index(){
        
        $this->load->model('entidades/m_usuario');
        $this->load->model('entidades/m_usuario_perfil');
                
        $usuario = new M_usuario($this->session->userdata('usuarioCodigo'));
        
        $usuarioLogado = utf8_decode($usuario->get_campos()->NOME);

        $usuarioPerfis = array();

        $perfilCodigos = $usuario->get_perfilCodigos();
        
        if (empty($perfilCodigos)){ // Verifica se o usuario esta sem perfil
            
            $perfilCodigos[] = M_constantes::SemPerfil;
            
            $usuarioPerfis[] = 'Sem Perfil atribu&iacute;do';
            
        }else{
            
            $perfis = $this->m_usuario_perfil->perfis($usuario->get_campos()->CODIGO);

            foreach($perfis as $perfil) {

                $usuarioPerfis[] = utf8_decode($perfil->ABREVIATURA);

            }
            
        }
        
        $this->session->set_userdata('usuarioPerfis', implode(', ', $usuarioPerfis));
        $this->session->set_userdata('usuarioNomePerfis', $usuarioLogado.'<br>'.implode(', ', $usuarioPerfis));
        $this->session->set_userdata('usuarioNome', $usuarioLogado);
        $this->session->set_userdata('perfilCodigos', $perfilCodigos);
                        
        $this->session->set_userdata('menus', $this->m_login->montaMenus($perfilCodigos));
        
        // Verifica o Usuário logado
        if (in_array(M_constantes::Administrador, $perfilCodigos)){
            
            $this->session->set_userdata('tema', 'azul/');
            $this->session->set_flashdata('logon', (bool)TRUE);
            redirect('atividades');
            
        }elseif (in_array(M_constantes::SemPerfil, $perfilCodigos)){
            
            $this->session->set_userdata('tema', 'azul/');
            redirect('sem_perfil');
            
        }else{
            
            $this->session->set_userdata('tema', 'azul/');
            redirect('atividades');
            
        }
        
    }
    
}

