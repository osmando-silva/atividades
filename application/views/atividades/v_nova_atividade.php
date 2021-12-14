<?php
if (!defined('BASEPATH')){ exit('Acesso direto ao arquivo não autorizado, log gerado!');}

?>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'jquery.validate.min.js'?>"></script>

<form id="form_nova_atividade">

    <strong>TÍTULO </strong><br>
    <input size="30" type="text" style="width:50%;" name="n_titulo" id="n_titulo" value="" /><br><br>

    <strong>DESCRIÇÃO </strong><br>
    <input size="20" type="text" style="width:85%;" name="n_desc" id="n_desc" value="" /><br><br>

    <strong>TIPO </strong><br>
    <?=$tipoAtividadeCombo?>

</form>

<div id="requerido" style="color: red;"></div>

<script type="text/javascript" language="javascript" src="<?=PATH_JS.'atividades/j_nova_atividade.js'?>"></script>
