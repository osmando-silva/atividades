<?php
if ( ! defined('BASEPATH')) exit('Acesso direto ao arquivo não autorizado, log gerado!');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
    
<title>Atividades</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
<link rel="shortcut icon" href="img/favicon.ico" />

<?php
        
    $tema = 'azul/';
                          
?>

    <link href="<?=PATH_CSS.$tema.'bootstrap.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=PATH_CSS.$tema.'bootstrap-theme.min.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=PATH_CSS.'geral.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=PATH_CSS.'login.css'?>" rel="stylesheet" type="text/css">
    <link href="<?=PATH_CSS.'input.css'?>" rel="stylesheet" type="text/css"> 
            
    <script type="text/javascript" language="javascript" src="<?= PATH_JS.'jquery-3.5.1.js'?>"></script>
    <script type="text/javascript" language="javascript" src="<?= PATH_JS.'bootstrap.js'?>"></script>
    <script type="text/javascript" language="javascript" src="<?= PATH_JS.'inputmask.bundle.js'?>"></script>
    <script type="text/javascript" language="javascript" src="<?= PATH_JS.'atividades.js'?>"></script>
            
</head>	

<body class="">
    
    <div id="corpo">
    
        <div align="center" style="z-index: 2; top: 0; height: 105px;" class="btn-primary" id="barra_titulo">

            <br> 
            <h2><?=NOMESISTEMA?> </h2>
            
        </div>