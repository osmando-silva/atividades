<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}

?>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'jquery.validate.min.js'?>"></script>

<form id="form_novo_usuario">

    <strong>CPF </strong><br>
    <input size="20" maxlength="14" requerido="true" type="text" placeholder="CPF" style="width:40%;" class="" name="n_login" id="n_login" value="" /><br><br>

    <strong>NOME </strong><br>
    <input size="30" type="text" requerido="true" style="width:85%;" placeholder="Nome do Usuário" name="n_nome" id="n_nome" value="" /><br><br>

    <strong>CONTATO </strong><br>
    <input size="20" type="text" placeholder="Contatos do Usuário" style="width:85%;" name="n_contato" id="n_contato" value="" /><br><br>

    <strong>E-MAIL </strong><br>
    <input size="20" type="text" requerido="true" placeholder="E-mail do Usuário" style="width:85%;" name="n_email" id="n_email" value="" />

</form>

<div id="requerido" style="color: red;"></div>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'administracao/j_novo_usuario.js'?>"></script>
