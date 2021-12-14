<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'c_principal';
$route['404_override'] = '';
$route['entrar'] = "c_login";
$route['sem_perfil'] = "c_sem_perfil";
$route['usuarios'] = "c_usuarios";
$route['registros'] = "c_registros";
$route['senha'] = "c_alterar_senha";
$route['negado'] = "c_acesso_negado";
$route['atividades'] = "c_atividades";
$route['tipos'] = "c_tipo_atividade";

$route['translate_uri_dashes'] = FALSE;
