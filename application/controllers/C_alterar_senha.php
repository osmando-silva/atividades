<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class C_alterar_senha extends S_Controller {
    
    public function index(){
        
        if(!$this->session->userdata('alterarSenha')){
            
            redirect();
    
        }
        
        $seq = rand(1000000,9999999);
        
        $this->session->set_userdata('seq', $seq);
        
        $data['login'] = $this->session->userdata('login');
        $data['novaSenha'] = '';
        $data['confirmaSenha'] = '';
        $data['seq'] = $seq;
        $this->template->showLogin('login/v_alterar_senha', $data); 
            
    }
    
    public function validate(){
        
        $this->load->library('Encryption');
        
        $login = $this->session->userdata('login');
        $seq = $this->session->userdata('seq');
        
        $encryption = new Encryption();
        
        $newpass = $encryption->decrypt($this->input->post('newpassw'), $seq);
        
        $confirmnewpass = $encryption->decrypt($this->input->post('confirmnewpassw'), $seq);

        if ($newpass != $confirmnewpass){
            
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('senhasNaoConferem',(bool)TRUE);
            redirect();
            
        }elseif ($newpass == $login){
            
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('senhaIgualLogin',(bool)TRUE);
            redirect();
            
        }elseif (strlen($newpass) < 8){
            
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('senhaCurta',(bool)TRUE);
            redirect();
        
        }elseif (!preg_match('/[A-Z]/', $newpass)){ // Deve conter 1 letra maiúscula não acentuada. Ç é perimitido
          
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('maiuscula',(bool)TRUE); 
            redirect();
        
        }
        
        elseif (!preg_match('/[a-z]/', $newpass)){ // Deve conter 1 letra minúscula não acentuada. ç é perimitido
          
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('minuscula',(bool)TRUE); 
            redirect();
        
        }elseif (!preg_match('/[0-9]/', $newpass)){ // Deve conter 1 número
          
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('numero',(bool)TRUE); 
            redirect();
        
        }elseif (preg_match('/[ \t]/', $newpass)){
          
            $this->session->set_userdata('login', $login);
            $this->session->set_flashdata('espaco',(bool)TRUE); // Não deve conter espaço ou tab
            redirect();
        
        }else{
            
            $this->load->model('entidades/m_usuario'); // Carrega a classe (model) da tabela USUARIO
            
            $usuario = new M_usuario();
            
            $novaSenha = password_hash($newpass, PASSWORD_DEFAULT);
            
            $dadosUsuario = $this->m_usuario->dadosUsuario($login);
            
            $usuarioCodigo = $dadosUsuario->CODIGO;
            
            if ($usuario->atualizarSenha($usuarioCodigo, $novaSenha)){  // Atualiza a senha na tabela USUARIO e testa se houve sucesso
                
                $this->m_log->gravaLog(utf8_encode("A senha do usuário login $login ($usuarioCodigo) foi alterada"), $usuarioCodigo);
                $this->session->set_userdata('login', $login);
                $this->session->set_flashdata('erroLogin', '2');
                redirect('entrar');
                
            }else{
                
                $this->session->set_userdata('login', $login);
                $this->session->set_flashdata('erroSenha', '5');
                redirect('senha');
                
            }
            
        }
         
    }
    
}