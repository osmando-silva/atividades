<?php

if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

/**
 * Classe de Entidade  -   M_Login
 * @since 05/05/2017
 * @author ST Osmando
 * @package models
 * */
class M_Login extends S_Model {
    
    private $menus;
    
    function __construct(){
        
        parent::__construct();
        
    }

    function apagaRelatorios($usuarioCodigo){
            
        $pasta = opendir (PATH_REL);
        
        while ($arquivo = readdir ($pasta)){
            
            if (strpos($arquivo, "-$usuarioCodigo.pdf")){
                
                unlink(PATH_REL.$arquivo); 
            
            }   
        } 
        
        closedir($pasta);
        
    }
    
    function apagaSessao($ip){
        
        $this->db->where('ip_address', $ip);
        $this->db->delete('SESSIONS');
        
    }
           
    function montaMenus($perfilCodigos){
        
        $codigosPerfil = implode(',', $perfilCodigos);
        
        $this->db->select("DISTINCT (M.CODIGO), M.TITULO, M.CODIGO_PAI, M.POSICAO, M.ICONE, 
                          (SELECT COUNT(ME.CODIGO) 
                            FROM MENU ME
                            WHERE ME.CODIGO = M.CODIGO
                            GROUP BY ME.CODIGO_PAI) TEM_FILHOS", FALSE);
        
        
        $this->db->from('MENU M');
        $this->db->join('PERFIL_MENU PM', 'PM.MENU_CODIGO = M.CODIGO','inner', FALSE);
        $this->db->join('USUARIO_PERFIL UP', 'UP.PERFIL_CODIGO = PM.PERFIL_CODIGO','inner', FALSE);
        $this->db->where('M.CODIGO_PAI', '0', FALSE);
        $this->db->where_in('UP.PERFIL_CODIGO', $codigosPerfil, FALSE);
        $this->db->order_by("M.POSICAO, M.TITULO",'ASC', FALSE);
                
        $menus_pai = $this->db->get()->result();
        
        $this->db->reset_query();
        
        foreach ($menus_pai as $menu_pai){
            
            if ($menu_pai->TEM_FILHOS){
                
                $this->menus .= '<li class="dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><i class="'.$menu_pai->ICONE.'"></i> '.utf8_decode($menu_pai->TITULO).'</a>';
                
                $this->menus .= '<ul class="dropdown-menu">';
                
                $this->menusFilhos($menu_pai->CODIGO, $codigosPerfil);
                
                $this->menus .= '</ul>';
                
            }else{
                
                $this->menus .= '<li><a class="nav-link" href="#"><i class="'.$menu_pai->ICONE.'"></i> '.utf8_decode($menu_pai->TITULO).'</a>';
                
            }
            
            $this->menus .= '</li>';
        
        }
		
        return $this->menus;
        
    }
    
    function menusFilhos($codigo_menu_pai, $codigosPerfil) {
        
        $this->db->select("DISTINCT (M.CODIGO), M.TITULO, M.LINK, M.CODIGO_PAI, M.POSICAO, M.ICONE, 
                          (SELECT COUNT(ME.CODIGO) 
                            FROM MENU ME
                            WHERE ME.CODIGO_PAI = M.CODIGO
                            GROUP BY ME.CODIGO_PAI) TEM_FILHOS", FALSE);
                
        $this->db->from('MENU M');
        $this->db->join('PERFIL_MENU PM', 'PM.MENU_CODIGO = M.CODIGO','inner', FALSE);
        $this->db->join('USUARIO_PERFIL UP', 'UP.PERFIL_CODIGO = PM.PERFIL_CODIGO','inner', FALSE);
        $this->db->where('M.CODIGO_PAI', $codigo_menu_pai, FALSE);
        $this->db->where_in('PM.PERFIL_CODIGO', $codigosPerfil, FALSE);
        $this->db->order_by("M.POSICAO, M.TITULO", FALSE);
        
        $menus_filhos = $this->db->get()->result();
        
        $this->db->reset_query();
        
        foreach ($menus_filhos as $menu_filho){
            
            if ($menu_filho->TEM_FILHOS){
                
//                $this->menus .= '<li><a class="dropdown" href="'.$menu_filho->LINK.'"><i class="'.$menu_filho->ICONE.'"></i> '.utf8_decode($menu_filho->TITULO).'</a>';
                
                $this->menus .= '<li class="dropdown-item"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="'.$menu_filho->ICONE.'"></i> '.utf8_decode($menu_filho->TITULO).'</a>';
                
                $this->menus .= '<ul class="dropdown-menu">';
                
                $this->menusFilhos($menu_filho->CODIGO, $codigosPerfil);
                
                $this->menus .= '</ul>';
                
            }else{
                
                $this->menus .= '<li><a class="dropdown-item" href="'.$menu_filho->LINK.'"><i class="'.$menu_filho->ICONE.'"></i> '.utf8_decode($menu_filho->TITULO).'</a>';
                
            }
            
            $this->menus .= '</li>';
            
        }
        
        return TRUE;  
        
    }
        
}