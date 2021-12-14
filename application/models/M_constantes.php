<?php

if (!defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');

/***
 * Classe de Constantes Diversas  -   M_Constantes
 * @since 01/12/2014
 * @author Sgt Osmando
 * @package models
 * */
class M_Constantes extends S_Model {
    
    function __construct(){
        
        parent::__construct();
        
    }
        
    # Códigos dos perfis
    const SemPerfil               = 0;
    const Administrador           = 1;
    const Usuario                 = 2;
    
    
    # Status das atividades
    const Aberta               = 0;
    const Concluida            = 1;
    
    
    # Status das atividades
    const HoraLimite           = "11:59";
    
    
    # Tipos de atividades
    const Atendimento          = 2;
    const ManutencaoUrgente    = 4;
        
    
    # Cores
    const laranja      = '#FF7F50';
    const laranjaClaro = '#F4A460';
    const verde        = '#32CD32';
    const verdeClaro   = '#98FB98';
    const azul         = '#1E90FF';
    const vermelho     = '#FF3030';
    const amarelo      = '#EEE8AA';
    const fundoTabela  = '#B0E0E6';
    
    # Estado do checkbox da validacao. &#9744; - Nao checado. &#9745; ou &#10004; - Checado
    const Checado         = "<img src=\"img/check_green_16_16.png\">";
    const NaoChecado      = "";
    
}
